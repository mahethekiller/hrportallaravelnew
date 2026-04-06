<?php

namespace App\Http\Controllers;

use App\Models\EmployeeResignation;
use App\Models\EmployeeResignationsLog;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ResignationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employees = collect();

        if ($user->can('view_all_resignations')) {
            // HR/Admin sees all employees
            $employees = Employee::where('is_active', 1)->orderBy('first_name')->get();
        } elseif ($user->can('view_team_resignations')) {
            // Manager sees their team + themselves
            $employees = Employee::where(function($q) use ($user) {
                $q->where('manager_id', $user->user_id)
                  ->orWhere('user_id', $user->user_id);
            })->where('is_active', 1)->orderBy('first_name')->get();
        } else {
            // Regular employee sees only themselves
            $employees = Employee::where('user_id', $user->user_id)->get();
        }

        return view('admin.resignations.index', compact('employees'));
    }

    public function data(Request $request)
    {
        $user = Auth::user();
        $query = EmployeeResignation::query()
            ->join('employees', 'employee_resignations.employee_id', '=', 'employees.user_id')
            ->leftJoin('companies', 'employee_resignations.company_id', '=', 'companies.company_id')
            ->select([
                'employee_resignations.*',
                'employees.first_name',
                'employees.last_name',
                'employees.employee_id as staff_code',
                'companies.name as company_name'
            ])
            ->where('show_status', 1);

        // Role-based filtering
        if ($user->can('view_all_resignations')) {
            // Admins see all
        } elseif ($user->can('view_team_resignations')) {
            // Manager sees their team's resignations + their own
            $query->where(function($q) use ($user) {
                $q->where('employee_resignations.manager_id', $user->user_id)
                  ->orWhere('employee_resignations.employee_id', $user->user_id);
            });
        } else {
            // Regular employee sees only their own
            $query->where('employee_resignations.employee_id', $user->user_id);
        }

        // Calculate stats for the top cards using the base query
        $statsData = (clone $query)->get();
        $stats = [
            'pending' => $statsData->where('status', 1)->count(),
            'manager_approved' => $statsData->where('status', 2)->count(),
            'hr_approved' => $statsData->where('status', 3)->count(),
            'rejected' => $statsData->where('status', 4)->count(),
        ];

        // Filters from the table form
        if ($request->employee_id) {
            $query->where('employee_resignations.employee_id', $request->employee_id);
        }
        if ($request->status && $request->status !== 'all') {
            $query->where('employee_resignations.status', $request->status);
        }

        $paginated = $query->orderBy('employee_resignations.created_at', 'desc')->paginate(10);

        return response()->json([
            'data' => $paginated->items(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'total' => $paginated->total(),
            'stats' => $stats
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer|exists:employees,user_id',
            'notice_date' => 'required|date',
            'reason' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $employee = Employee::findOrFail($request->employee_id);
        $noticePeriod = $employee->notice_period ?? 30; // Default 30 days

        // Calculate last working day
        $noticeDate = Carbon::parse($request->notice_date);
        $resignationDate = $noticeDate->copy()->addDays($noticePeriod);

        $resignation = EmployeeResignation::create([
            'company_id' => $employee->company_id ?? 0,
            'employee_id' => $request->employee_id,
            'manager_id' => $employee->manager_id ?? 0,
            'notice_date' => $request->notice_date,
            'resignation_date' => $resignationDate->format('Y-m-d'),
            'requested_notice' => $noticePeriod,
            'reason' => $request->reason,
            'status' => '1', // Pending
            'manager_status' => '',
            'hr_status' => '',
            'manager_comment' => '',
            'hr_comment' => '',
            'added_by' => $user->user_id,
            'show_status' => 1,
            'comments' => '',
            'it_comment' => '',
            'it_status' => '',
            'account_status' => '',
            'account_comment' => '',
            'head_status' => '',
            'it_person' => '',
            'account_per' => '',
            'hr_person' => '',
            'manager_person' => '',
            'sage_person' => '',
            'login_person' => '',
            'coo_status' => '',
            'coo_comment' => '',
            'sage_status' => 0,
            'sage_comment' => '',
            'employee_accept' => '',
            'login_status' => '',
            'login_comment' => '',
        ]);

        // Log
        EmployeeResignationsLog::create([
            'resignation_id' => $resignation->resignation_id,
            'company_id' => $employee->company_id ?? 0,
            'employee_id' => $request->employee_id,
            'notice_date' => $request->notice_date,
            'resignation_date' => $resignationDate->format('Y-m-d'),
            'reason' => $request->reason,
            'added_by' => $user->user_id,
            'updated_by' => $user->user_id,
            'updated_date' => now()->format('Y-m-d'),
        ]);

        return response()->json(['success' => 'Resignation submitted successfully. Last working day: ' . $resignationDate->format('d M Y')]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'comment' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $resignation = EmployeeResignation::findOrFail($id);
        $action = $request->action;
        $comment = $request->comment ?? '';

        if ($user->can('approve_resignations_hr')) {
            // HR can approve or reject at any stage
            $resignation->hr_status = ($action === 'approve') ? 'approved' : 'rejected';
            $resignation->hr_comment = $comment;
            $resignation->hr_person = $user->user_id;
            $resignation->status = ($action === 'approve') ? '3' : '4';

            // If approved, update employee resign_date
            if ($action === 'approve') {
                Employee::where('user_id', $resignation->employee_id)->update([
                    'resign_date' => $resignation->resignation_date,
                ]);
            }
        } elseif ($user->can('approve_resignations_manager')) {
            // Manager approval
            $resignation->manager_status = ($action === 'approve') ? 'approved' : 'rejected';
            $resignation->manager_comment = $comment;
            $resignation->manager_person = $user->user_id;
            $resignation->status = ($action === 'approve') ? '2' : '4';
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $resignation->save();

        $statusText = ($action === 'approve') ? 'approved' : 'rejected';
        return response()->json(['success' => "Resignation {$statusText} successfully."]);
    }

    public function getNoticePeriod($employee_id)
    {
        $employee = Employee::find($employee_id);
        if (!$employee) {
            return response()->json(['notice_period' => 30]);
        }
        return response()->json([
            'notice_period' => $employee->notice_period ?? 30,
            'manager_name' => $employee->manager_id
                ? optional(Employee::find($employee->manager_id))->first_name . ' ' . optional(Employee::find($employee->manager_id))->last_name
                : 'Not Assigned',
        ]);
    }
}
