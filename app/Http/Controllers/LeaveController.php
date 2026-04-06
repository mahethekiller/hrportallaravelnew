<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use App\Models\LeaveType;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class LeaveController extends Controller
{
    public function index()
    {
        $employees = [];
        $user = Auth::user();

        if ($user->can('view_all_leaves')) {
            $employees = Employee::orderBy('first_name')->get();
        } elseif ($user->can('view_team_leaves')) {
            $employees = Employee::where('manager_id', $user->user_id)->orderBy('first_name')->get();
        }

        $leaveTypes = LeaveType::all();

        return view('admin.leaves.index', compact('employees', 'leaveTypes'));
    }

    public function data(Request $request)
    {
        $user = Auth::user();

        $query = LeaveApplication::query()
            ->join('employees', 'leave_applications.employee_id', '=', 'employees.user_id')
            ->join('leave_type', 'leave_applications.leave_type_id', '=', 'leave_type.leave_type_id')
            ->select([
                'leave_applications.leave_id',
                'leave_applications.employee_id',
                'leave_applications.from_date',
                'leave_applications.to_date',
                'leave_applications.applied_on',
                'leave_applications.status',
                'leave_applications.reason',
                'leave_applications.remarks',
                'employees.first_name',
                'employees.last_name',
                'leave_type.type_name'
            ]);

        // Role-based filtering
        if ($user->can('view_all_leaves')) {
            // Admins see all
        } elseif ($user->can('view_team_leaves')) {
            $query->where('employees.manager_id', $user->user_id);
        } else {
            $query->where('leave_applications.employee_id', $user->user_id);
        }

        // Filters from the form
        if ($request->employee_id) {
            $query->where('leave_applications.employee_id', $request->employee_id);
        }
        if ($request->status) {
            $query->where('leave_applications.status', $request->status);
        }

        return DataTables::of($query)
            ->filterColumn('employee_name', function($q, $keyword) {
                $q->whereRaw("CONCAT(employees.first_name, ' ', employees.last_name) like ?", ["%{$keyword}%"]);
            })
            ->addColumn('employee_name', function($row) {
                return $row->first_name . ' ' . $row->last_name;
            })
            ->addColumn('initials', function($row) {
                 return strtoupper(substr($row->first_name ?? 'U', 0, 1) . substr($row->last_name ?? 'N', 0, 1));
            })
            ->addColumn('duration', function($row) {
                $from = Carbon::parse($row->from_date);
                $to = Carbon::parse($row->to_date);
                return ($from->diffInDays($to) + 1) . ' Days';
            })
            ->editColumn('from_date', function($row) {
                return Carbon::parse($row->from_date)->format('d M Y');
            })
            ->editColumn('to_date', function($row) {
                return Carbon::parse($row->to_date)->format('d M Y');
            })
            ->editColumn('applied_on', function($row) {
                return Carbon::parse($row->applied_on)->format('d M Y');
            })
            ->addColumn('status_label', function($row) {
                $statusStr = 'Pending';
                $statusClass = 'warning';
                if ($row->status == 2) { $statusStr = 'Approved'; $statusClass = 'success'; }
                elseif ($row->status == 3) { $statusStr = 'Rejected'; $statusClass = 'danger'; }
                return '<span class="status-badge bg-'.$statusClass.'-subtle text-'.$statusClass.'">'.$statusStr.'</span>';
            })
            ->addColumn('actions', function($row) {
                 // Pass full row data to JS function
                 $json = htmlspecialchars(json_encode([
                    'leave_id' => $row->leave_id,
                    'employee_name' => $row->first_name . ' ' . $row->last_name,
                    'leave_type' => $row->type_name,
                    'from_date' => Carbon::parse($row->from_date)->format('d M Y'),
                    'to_date' => Carbon::parse($row->to_date)->format('d M Y'),
                    'duration' => (Carbon::parse($row->from_date)->diffInDays(Carbon::parse($row->to_date)) + 1) . ' Days',
                    'applied_on' => Carbon::parse($row->applied_on)->format('d M Y'),
                    'status' => $row->status == 2 ? 'Approved' : ($row->status == 3 ? 'Rejected' : 'Pending'),
                    'status_class' => $row->status == 2 ? 'success' : ($row->status == 3 ? 'danger' : 'warning'),
                    'reason' => $row->reason,
                    'remarks' => $row->remarks,
                    'initials' => strtoupper(substr($row->first_name ?? 'U', 0, 1) . substr($row->last_name ?? 'N', 0, 1)),
                 ]), ENT_QUOTES, 'UTF-8');
                 return '<button class="btn btn-sm btn-link text-primary p-0 text-decoration-none small" onclick="showLeaveDetails('.$json.')">View Details</button>';
            })
            ->rawColumns(['status_label', 'actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required'
        ]);

        $leave = new LeaveApplication();
        $leave->employee_id = Auth::id();
        $leave->company_id = Auth::user()->company_id ?? 1;
        $leave->leave_type_id = $request->leave_type_id;
        $leave->from_date = $request->from_date;
        $leave->to_date = $request->to_date;
        $leave->applied_on = now()->toDateString();
        $leave->reason = $request->reason;
        $leave->status = 1; // Pending
        $leave->start_duration = 'Full Day';
        $leave->end_duration = 'Full Day';
        $leave->casual_deducted = 0;
        $leave->earned_deducted = 0;
        $leave->remarks = '';
        $leave->save();

        return response()->json(['success' => true, 'message' => 'Leave application submitted successfully!']);
    }

    public function updateStatus(Request $request, $id)
    {
        $leave = LeaveApplication::findOrFail($id);

        if (!Auth::user()->can('manage_leaves')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $leave->status = $request->status;
        $leave->remarks = $request->remarks;
        $leave->save();

        return response()->json(['success' => true, 'message' => 'Leave status updated successfully!']);
    }
}
