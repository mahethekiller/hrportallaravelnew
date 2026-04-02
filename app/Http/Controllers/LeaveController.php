<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use App\Models\LeaveType;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $query = LeaveApplication::with(['employee', 'leaveType']);

        // Role-based filtering
        if ($user->can('view_all_leaves')) {
            // Admins see all
        } elseif ($user->can('view_team_leaves')) {
            $query->whereHas('employee', function($q) use ($user) {
                $q->where('manager_id', $user->user_id);
            });
        } else {
            $query->where('employee_id', $user->user_id);
        }

        // Filters
        if ($request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $leaves = $query->orderBy('applied_on', 'desc')->get();

        $data = $leaves->map(function($leave) {
            $statusStr = 'Pending';
            $statusClass = 'warning';
            if ($leave->status == 2) { $statusStr = 'Approved'; $statusClass = 'success'; }
            elseif ($leave->status == 3) { $statusStr = 'Rejected'; $statusClass = 'danger'; }

            $from = Carbon::parse($leave->from_date);
            $to = Carbon::parse($leave->to_date);
            $duration = $from->diffInDays($to) + 1;

            return [
                'leave_id' => $leave->leave_id,
                'employee_name' => ($leave->employee->first_name ?? 'Unknown') . ' ' . ($leave->employee->last_name ?? ''),
                'leave_type' => $leave->leaveType->type_name ?? 'N/A',
                'from_date' => $from->format('d M Y'),
                'to_date' => $to->format('d M Y'),
                'duration' => $duration . ' Days',
                'applied_on' => Carbon::parse($leave->applied_on)->format('d M Y'),
                'status' => $statusStr,
                'status_class' => $statusClass,
                'reason' => $leave->reason,
                'remarks' => $leave->remarks,
                'initials' => strtoupper(substr($leave->employee->first_name ?? 'U', 0, 1) . substr($leave->employee->last_name ?? 'N', 0, 1)),
            ];
        });

        return response()->json(['data' => $data]);
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
