<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    public function index()
    {
        // Fetch candidates with their related job titles
        $candidates = DB::table('job_applications as app')
            ->leftJoin('jobs as j', 'app.job_id', '=', 'j.job_id')
            ->select('app.*', 'j.job_title', 'j.job_code as post_code')
            ->where('app.show_status', 1)
            ->orderBy('app.application_id', 'desc')
            ->get();

        return view('admin.recruitment.candidates.index', compact('candidates'));
    }

    public function create()
    {
        $jobs = DB::table('jobs')->where('show_status', 1)->get();
        $companies = DB::table('companies')->get();
        return view('admin.recruitment.candidates.create', compact('jobs', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_name' => 'required',
            'email' => 'required|email',
            'job_id' => 'required',
            'job_resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['_token', 'job_resume', 'profile_picture']);
        
        // Handle Resume Upload
        if ($request->hasFile('job_resume')) {
            $file = $request->file('job_resume');
            $filename = 'resume_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/resumes', $filename);
            $data['job_resume'] = $filename;
        }

        // Handle Profile Picture
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profiles', $filename);
            $data['profile_picture'] = $filename;
        }

        $data['application_status'] = 'Applied';
        $data['show_status'] = 1;
        $data['legacy_created_at'] = now();

        DB::table('job_applications')->insert($data);

        return redirect()->route('candidates.index')->with('success', 'Candidate added to the talent pipeline!');
    }

    public function show($id)
    {
        $candidate = DB::table('job_applications as app')
            ->leftJoin('jobs as j', 'app.job_id', '=', 'j.job_id')
            ->select('app.*', 'j.job_title', 'j.job_code as post_code')
            ->where('app.application_id', $id)
            ->first();

        if (!$candidate) {
            return redirect()->route('candidates.index')->with('error', 'Candidate not found');
        }

        // Get interview history
        $interviews = DB::table('job_interviews')
            ->where('application_id', $id)
            ->where('show_status', 1)
            ->get();

        return view('admin.recruitment.candidates.show', compact('candidate', 'interviews'));
    }

    public function edit($id)
    {
        $candidate = DB::table('job_applications')->where('application_id', $id)->first();
        $jobs = DB::table('jobs')->where('show_status', 1)->get();
        $companies = DB::table('companies')->get();
        
        return view('admin.recruitment.candidates.edit', compact('candidate', 'jobs', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'candidate_name' => 'required',
            'email' => 'required|email',
            'job_id' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'job_resume', 'profile_picture']);
        
        // Handle Resume Upload
        if ($request->hasFile('job_resume')) {
            $file = $request->file('job_resume');
            $filename = 'resume_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/resumes', $filename);
            $data['job_resume'] = $filename;
        }

        // Handle Profile Picture
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profiles', $filename);
            $data['profile_picture'] = $filename;
        }

        $data['updated_date'] = now();

        DB::table('job_applications')->where('application_id', $id)->update($data);

        return redirect()->route('candidates.show', $id)->with('success', 'Candidate details updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('job_applications')->where('application_id', $id)->update(['show_status' => 0]);
        return redirect()->route('candidates.index')->with('success', 'Candidate removed from pipeline');
    }

    public function convert($id)
    {
        $candidate = DB::table('job_applications')->where('application_id', $id)->first();
        if (!$candidate) {
            return redirect()->back()->with('error', 'Candidate not found');
        }

        // Check not already converted
        if ($candidate->application_status === 'Converted') {
            return redirect()->back()->with('error', 'This candidate has already been converted to an employee.');
        }

        // Split name
        $names   = explode(' ', $candidate->candidate_name, 2);
        $first   = $names[0];
        $last    = $names[1] ?? '';

        // Get Job info for department/designation mapping
        $job = DB::table('jobs')->where('job_id', $candidate->job_id)->first();

        // Unique identifiers
        $empId   = 'EMP-' . strtoupper(substr($first, 0, 3)) . rand(1000, 9999);
        $username = strtolower($first . '.' . rand(100, 999));

        // Full employee data with ALL required legacy fields defaulted
        $employeeData = [
            // Core Identity
            'employee_id'          => $empId,
            'first_name'           => $first,
            'last_name'            => $last,
            'username'             => $username,
            'email'                => $candidate->email,
            'email_personal'       => $candidate->email,
            'password'             => bcrypt('Welcome@123'),

            // Organizational
            'company_id'           => $job ? $job->company_id : 1,
            'department_id'        => $job ? $job->department : 1,
            'designation_id'       => $job ? ($job->designation_id ?? 1) : 1,
            'office_shift_id'      => 1,
            'user_role_id'         => 4,
            'manager_id'           => 0,
            'sub_manager_id'       => 0,
            'sub_department'       => '',
            'reporting_location'   => '',
            'employment_type'      => 'Full Time',

            // Legacy numeric defaults (NOT NULL fields without defaults)
            'card_no'              => 0,
            'hourly_grade_id'      => 0,
            'monthly_grade_id'     => 0,
            'ref_emp_id'           => 0,
            'rejoin_emp_id'        => 0,
            'other_leaves_taken_days' => 0,
            'notice_period'        => (int)($candidate->notice_period ?? 0),
            'experience'           => (float)($candidate->experience ?? 0),

            // Personal
            'gender'               => $candidate->gender ?? 'Male',
            'date_of_birth'        => '1990-01-01',
            'date_of_birth_doc'    => '',
            'marital_status'       => '',
            'mother_tongue'        => '',
            'age'                  => '',
            'place_of_birth'       => '',
            'blood_group'          => '',
            'category'             => '',

            // Contact & Address
            'contact_no'           => $candidate->contact_no ?? '',
            'official_contact_no'  => '',
            'address'              => $candidate->current_location ?? '',
            'address_com'          => '',
            'city'                 => '',
            'state'                => '',
            'pincode'              => '',
            'city_temp'            => '',
            'state_temp'           => '',
            'pin_temp'             => '',

            // IDs & Finance
            'pan_number'           => '',
            'aadhar_no'            => '',
            'corporate_bank_account' => '',
            'paytm_no'             => '',
            'salary'               => '0',
            'salary_template'      => '',
            'earned_leave'         => '0',
            'casual_leave'         => '0',
            'pf_opted'             => 'no',
            'health_ins_opted'     => 'no',

            // Dates
            'date_of_joining'      => now()->format('Y-m-d'),
            'date_of_leaving'      => '',
            'probation_status'     => '',
            'probation_end_date'   => '',
            'confirmation_date'    => '',
            'resign_date'          => '',

            // Documents & Social
            'profile_picture'      => '',
            'profile_background'   => '',
            'resume'               => $candidate->job_resume ?? '',
            'kra_doc'              => '',
            'kpi_doc'              => null,
            'skype_id'             => '',
            'facebook_link'        => '',
            'twitter_link'         => '',
            'blogger_link'         => '',
            'linkdedin_link'       => '',
            'google_plus_link'     => '',
            'instagram_link'       => '',
            'pinterest_link'       => '',
            'youtube_link'         => '',

            // Vehicle
            'vehicle_no'           => '',
            'vehicle_type'         => '',

            // Status & Metadata
            'employee_source'      => 'Recruitment',
            'e_status'             => 1,
            'is_active'            => 1,
            'is_logged_in'         => 0,
            'online_status'        => 0,
            'has_rejoined'         => 'no',
            'prob_mail_status'     => null,
            'last_login_date'      => '',
            'last_logout_date'     => '',
            'last_login_ip'        => '',
            'refreshToken'         => null,
            'created_by'           => auth()->id() ?? 1,
            'legacy_created_at'    => now(),
            'created_at'           => now(),
            'updated_at'           => now(),
        ];

        DB::beginTransaction();
        try {
            $newUserId = DB::table('employees')->insertGetId($employeeData);

            // Update application status
            DB::table('job_applications')->where('application_id', $id)->update([
                'application_status' => 'Converted',
            ]);

            DB::commit();

            return redirect()->route('employees.edit', $newUserId)
                ->with('success', "✅ {$candidate->candidate_name} was converted to Employee successfully! Default password: Welcome@123");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Conversion failed: ' . $e->getMessage());
        }
    }
}
