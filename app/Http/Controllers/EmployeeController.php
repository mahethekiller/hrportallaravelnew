<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('employees')
                ->leftJoin('companies', 'employees.company_id', '=', 'companies.company_id')
                ->leftJoin('departments', 'employees.department_id', '=', 'departments.department_id')
                ->leftJoin('designations', 'employees.designation_id', '=', 'designations.designation_id')
                ->leftJoin('employees as managers', 'employees.manager_id', '=', 'managers.user_id')
                ->leftJoin('model_has_roles', function($join) {
                    $join->on('employees.user_id', '=', 'model_has_roles.model_id')
                         ->where('model_has_roles.model_type', '=', 'App\Models\Employee');
                })
                ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select([
                    'employees.user_id',
                    'employees.employee_id',
                    'employees.first_name',
                    'employees.last_name',
                    'employees.email',
                    'employees.contact_no',
                    'employees.date_of_birth',
                    'employees.date_of_joining',
                    'employees.blood_group',
                    'employees.profile_picture',
                    'employees.is_active',
                    'companies.name as company_name',
                    'departments.department_name',
                    'designations.designation_name',
                    DB::raw("CONCAT(managers.first_name, ' ', managers.last_name) as manager_name"),
                    'roles.name as role_name'
                ]);

            // Advanced Filtering
            if ($request->filled('filter_company')) {
                $query->where('employees.company_id', $request->filter_company);
            }
            if ($request->filled('filter_manager')) {
                $query->where('employees.manager_id', $request->filter_manager);
            }
            if ($request->filled('filter_status')) {
                $query->where('employees.is_active', $request->filter_status);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('avatar', function($row) {
                    $img = $row->profile_picture ? asset('storage/profiles/' . $row->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($row->first_name) . '&background=random';
                    return '<img src="'.$img.'" class="avatar shadow-sm" alt="Avatar">';
                })
                ->addColumn('name', function($row) {
                    return '<div class="fw-bold">' . $row->first_name . ' ' . $row->last_name . '</div><small class="text-muted">' . $row->employee_id . '</small>';
                })
                ->addColumn('organization', function($row) {
                    return '<div class="small"><strong>' . ($row->company_name ?? 'N/A') . '</strong><br>' . ($row->department_name ?? 'Dept.') . '</div>';
                })
                ->addColumn('status', function($row) {
                    $class = $row->is_active ? 'success' : 'danger';
                    $text = $row->is_active ? 'Active' : 'Inactive';
                    return '<span class="badge bg-'.$class.'-subtle text-'.$class.' border border-'.$class.' rounded-pill px-3">'.$text.'</span>';
                })
                ->addColumn('manager', function($row) {
                    return $row->manager_name ?? '<span class="text-muted small">No Manager</span>';
                })
                ->addColumn('dates', function($row) {
                    try {
                        $join = $row->date_of_joining ? \Carbon\Carbon::parse(trim($row->date_of_joining, '-'))->format('M d, Y') : 'N/A';
                    } catch (\Exception $e) {
                        $join = $row->date_of_joining ?: 'N/A'; // Fallback to raw value if parsing fails
                    }
                    return '<div class="small">Joined: ' . $join . '</div>';
                })
                ->rawColumns(['avatar', 'name', 'organization', 'status', 'manager', 'dates'])
                ->make(true);
        }

        $companies = DB::table('companies')->get();
        $roles = DB::table('roles')->get();
        // Fetch only those who are assigned as managers to keep filter clean
        $managers = DB::table('employees')
            ->whereIn('user_id', DB::table('employees')->whereNotNull('manager_id')->pluck('manager_id'))
            ->select('user_id', 'first_name', 'last_name')
            ->get();

        return view('admin.employees.index', compact('companies', 'roles', 'managers'));
    }

    public function store(Request $request)
    {
        if (!\Illuminate\Support\Facades\Auth::user()->can('manage_employees')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'employee_id' => 'required|unique:employees,employee_id',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|min:6',
            'role_name' => 'required',
            'company_id' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $employee = Employee::create([
                'employee_id' => $request->employee_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'username' => $request->employee_id, // Sync username with employee_id
                'password' => Hash::make($request->password),
                'company_id' => $request->company_id,
                'department_id' => $request->department_id,
                'designation_id' => $request->designation_id,
                'gender' => $request->gender ?? 'Male',
                'is_active' => true,
                'user_role_id' => 1, // Legacy sync
            ]);

            $employee->assignRole($request->role_name);

            DB::commit();
            return response()->json(['success' => 'Employee created successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        if (!\Illuminate\Support\Facades\Auth::user()->can('manage_employees')) {
            abort(403, 'Unauthorized action.');
        }

        $employee = Employee::findOrFail($id);
        $companies = DB::table('companies')->get();
        $departments = DB::table('departments')->where('company_id', $employee->company_id)->get();
        $designations = DB::table('designations')->where('department_id', $employee->department_id)->get();
        $roles = DB::table('roles')->get();
        $managers = DB::table('employees')->where('user_id', '!=', $id)->get();

        // Extended Profile Data
        $emergency_contacts = DB::table('employee_contacts')->where('employee_id', $id)->get();
        $qualifications = DB::table('employee_qualification')->where('employee_id', $id)->get();
        $work_experience = DB::table('employee_work_experience')->where('employee_id', $id)->get();
        $verification = DB::table('emp_verify')->where('userid', $id)->first();
        $reimbursements = DB::table('emp_certificate_claim')->where('userid', $id)->get();

        $acceptance_forms = DB::table('announcement_submissions')
            ->join('announcements', 'announcement_submissions.announcement_id', '=', 'announcements.announcement_id')
            ->where('announcement_submissions.user_id', $id)
            ->select('announcement_submissions.*', 'announcements.image', 'announcements.title')
            ->get();

        // Metadata for Dropdowns
        $education_levels = DB::table('qualification_education_level')->get();
        $languages = DB::table('languages')->get();
        $office_shifts = \App\Models\OfficeShift::all();
        $sub_departments = DB::table('sub_departments')->where('department_id', $employee->department_id)->where('show_status', 1)->get();

        // New: Recruiters and Vendors for Dynamic Source Logic
        $recruiters = DB::table('employees')
            ->join('model_has_roles', 'employees.user_id', '=', 'model_has_roles.model_id')
            ->whereIn('model_has_roles.role_id', [3, 7, 17, 21])
            ->select('employees.user_id', 'employees.first_name', 'employees.last_name', 'employees.employee_id')
            ->get();
        
        $vendors = DB::table('emp_vendors')->where('show_status', 1)->get();

        return view('admin.employees.edit', compact(
            'employee', 'companies', 'departments', 'designations', 'roles', 'managers',
            'emergency_contacts', 'qualifications', 'work_experience', 'verification', 'reimbursements', 'acceptance_forms',
            'education_levels', 'languages', 'office_shifts', 'sub_departments', 'recruiters', 'vendors'
        ));

    }

    public function update(Request $request, $id)
    {
        if (!\Illuminate\Support\Facades\Auth::user()->can('manage_employees')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $employee = Employee::findOrFail($id);

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employees,email,'.$id.',user_id',
            'role_name' => 'required',
            'company_id' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'kra_doc' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'kpi_doc' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->except(['_token', '_method', 'profile_picture', 'resume', 'kra_doc', 'kpi_doc', 'role_name', 'password_confirmation', 'ref_emp_id_emp', 'ref_emp_id_rec', 'ref_emp_id_ven']);

        // Default relation IDs to 0 for legacy DB compatibility
        $data['ref_emp_id'] = 0;
        $data['rejoin_emp_id'] = $request->rejoin_emp_id ?? 0;

        // Map the correct referral ID based on source
        if (in_array($request->employee_source, ['Reference', 'Referral'])) {
            $data['ref_emp_id'] = $request->ref_emp_id_emp ?? 0;
        } elseif (in_array($request->employee_source, ['Recruiter', 'Job Board'])) {
            $data['ref_emp_id'] = $request->ref_emp_id_rec ?? 0;
        } elseif ($request->employee_source == 'Vendor') {
            $data['ref_emp_id'] = $request->ref_emp_id_ven ?? 0;
        }

        // Handle Profile Picture Upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = time() . '_profile_' . $id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/profiles'), $fileName);
            $data['profile_picture'] = $fileName;
        }

        // Handle Resume Upload
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $fileName = time() . '_resume_' . $id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/cvs'), $fileName);
            $data['resume'] = $fileName;
        }

        // Handle KRA Doc Upload
        if ($request->hasFile('kra_doc')) {
            $file = $request->file('kra_doc');
            $fileName = time() . '_kra_' . $id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/docs'), $fileName);
            $data['kra_doc'] = $fileName;
        }

        // Handle KPI Doc Upload
        if ($request->hasFile('kpi_doc')) {
            $file = $request->file('kpi_doc');
            $fileName = time() . '_kpi_' . $id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/docs'), $fileName);
            $data['kpi_doc'] = $fileName;
        }

        // Handle Password Update if filled
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        // Map nulls to empty strings for fields that database requires NOT NULL
        $nullableFields = [
            'mother_tongue', 'blood_group', 'category', 'city', 'state', 'pincode', 'address', 'marital_status',
            'email_personal', 'date_of_birth_doc', 'age', 'place_of_birth', 'pan_number', 'aadhar_no', 
            'address_com', 'paytm_no', 'vehicle_no', 'official_contact_no', 'vehicle_type', 
            'city_temp', 'state_temp', 'pin_temp', 'kra_doc', 'contact_no',
            'facebook_link', 'twitter_link', 'blogger_link', 'linkdedin_link', 'google_plus_link',
            'instagram_link', 'pinterest_link', 'youtube_link', 'skype_id',
            'pf_opted', 'employee_source', 'probation_status', 'probation_end_date', 'confirmation_date',
            'resign_date', 'has_rejoined', 'corporate_bank_account', 'salary', 'employment_type',
            'notice_period', 'card_no'
        ];

        foreach($nullableFields as $field) {
            if (!$request->filled($field) && !isset($data[$field])) {
                $data[$field] = '';
            }
        }
        
        // Handle numeric fields
        if(!$request->filled('experience')) {
            $data['experience'] = 0;
        }

        // Checkboxes check
        $data['pf_opted'] = $request->has('pf_opted') ? 'yes' : 'no';
        $data['health_ins_opted'] = $request->has('health_ins_opted') ? 'yes' : 'no';
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        
        // Ensure username is updated if employee_id is updated (or just ensure it matches)
        // Note: employee_id is usually readonly in UI, but we'll ensure the sync.
        if($request->filled('employee_id')) {
            $data['username'] = $request->employee_id;
        }

        $employee->update($data);
        $employee->syncRoles([$request->role_name]);

        return response()->json(['success' => 'Employee updated successfully.']);
    }

    public function destroy($id)
    {
        if (!\Illuminate\Support\Facades\Auth::user()->can('manage_employees')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        Employee::findOrFail($id)->delete();
        return response()->json(['success' => 'Employee deleted successfully.']);
    }
}
