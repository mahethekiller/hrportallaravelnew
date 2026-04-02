<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\EmpTodayAttendance;
use DateTime;
use DateInterval;
use DatePeriod;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Determine role-based visibility
        $isAdmin = $user->can('view_all_attendance');
        
        if ($isAdmin) {
            $employees = DB::table('employees')
                           ->where('is_active', 1)
                           ->select('user_id', 'first_name', 'last_name', 'employee_id')
                           ->orderBy('first_name')
                           ->get();
        } else {
            // Managers see themselves + their reports
            $employees = DB::table('employees')
                           ->where('is_active', 1)
                           ->where(function($q) use ($user) {
                               $q->where('user_id', $user->user_id)
                                 ->orWhere('manager_id', $user->user_id)
                                 ->orWhere('sub_manager_id', $user->user_id);
                           })
                           ->select('user_id', 'first_name', 'last_name', 'employee_id')
                           ->orderBy('first_name')
                           ->get();
        }

        return view('admin.attendance.index', compact('employees'));
    }

    public function data(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->can('view_all_attendance');

        // Requested filters
        $employee_id = $request->get('employee_id');
        if (!$employee_id) {
            $employee_id = $user->user_id; // Default to self
        }

        // Authorization Check
        if (!$isAdmin && $employee_id != $user->user_id) {
            $isManager = DB::table('employees')
                           ->where('user_id', $employee_id)
                           ->where(function($q) use ($user) {
                               $q->where('manager_id', $user->user_id)
                                 ->orWhere('sub_manager_id', $user->user_id);
                           })->exists();
            if (!$isManager) {
                return response()->json(['error' => 'Unauthorized attendance view.'], 403);
            }
        }

        $employee = DB::table('employees')->where('user_id', $employee_id)->first();
        if (!$employee) {
            return response()->json(['data' => []]);
        }
        
        $company = \App\Models\Company::where('company_id', $employee->company_id)->first();
        $comp_name = $company ? $company->name : '--';
        $full_name = trim($employee->first_name . ' ' . $employee->last_name);

        $start_date_str = $request->get('start_date') ?: date('Y-m-d');
        $end_date_str = $request->get('end_date') ?: date('Y-m-d');

        try {
            $start_date = new DateTime($start_date_str);
            $end_date = new DateTime($end_date_str);
            $end_date->modify('+1 day');
            
            $interval = new DateInterval('P1D');
            $date_range = new DatePeriod($start_date, $interval, $end_date);
        } catch (\Exception $e) {
            return response()->json(['data' => []]);
        }

        // Pre-fetch all attendance for this employee in the range using card_no
        $attendances = EmpTodayAttendance::where('card_no', $employee->card_no)
            ->whereBetween('punch_date', [$start_date_str, (clone $end_date)->modify('-1 day')->format('Y-m-d')])
            ->orderBy('id', 'asc')
            ->get();
            
        // Group attendances by date (using the punch_date string)
        $att_map = [];
        foreach($attendances as $a) {
            $punch_date_str = $a->punch_date instanceof \Carbon\Carbon ? $a->punch_date->format('Y-m-d') : date('Y-m-d', strtotime($a->punch_date));
            $att_map[$punch_date_str][] = $a;
        }

        // Pre-fetch Holiday Ranges
        $holidays = \App\Models\Holiday::all();
        $holiday_arr = [];
        foreach ($holidays as $hol) {
            try {
                $h_start = new DateTime($hol->start_date);
                $h_end = new DateTime($hol->end_date);
                $h_end->modify('+1 day');
                foreach (new DatePeriod($h_start, new DateInterval('P1D'), $h_end) as $hdt) {
                    $holiday_arr[] = $hdt->format('Y-m-d');
                }
            } catch (\Exception $e) { continue; }
        }

        // Pre-fetch Leaves for this Employee
        $leaves = \App\Models\LeaveApplication::where('employee_id', $employee_id)->get();
        $leave_arr = [];
        foreach ($leaves as $lv) {
            try {
                $l_start = new DateTime($lv->from_date);
                $l_end = new DateTime($lv->to_date);
                $l_end->modify('+1 day');
                foreach (new DatePeriod($l_start, new DateInterval('P1D'), $l_end) as $ldt) {
                    $leave_arr[] = $ldt->format('Y-m-d');
                }
            } catch (\Exception $e) { continue; }
        }

        $office_shift = \App\Models\OfficeShift::where('office_shift_id', $employee->office_shift_id)->first();

        $data = [];
        $userTz = 'Asia/Kolkata';
        
        foreach ($date_range as $date) {
            $attendance_date = $date->format('Y-m-d');
            $day = $date->format('l');

            $day_attendances = $att_map[$attendance_date] ?? [];
            
            $status = '';
            $total_work_minutes = 0;
            $clock_in_str = '--:--';
            $clock_out_str = '--:--';

            if (count($day_attendances) > 0) {
                $status = "Present";
                $first_in = $day_attendances[0];
                $last_out = end($day_attendances);

                if (!empty($first_in->check_in_time) && $first_in->check_in_time != '00:00:00') {
                    $clock_in_str = date('h:i A', strtotime($first_in->check_in_time));
                }

                if (!empty($last_out->check_out_time) && $last_out->check_out_time != '00:00:00') {
                    $clock_out_str = date('h:i A', strtotime($last_out->check_out_time));
                }

                foreach($day_attendances as $record) {
                    if (!empty($record->check_in_time) && $record->check_in_time != '00:00:00') {
                        try {
                            $pDate = $record->punch_date instanceof \Carbon\Carbon ? $record->punch_date->format('Y-m-d') : $record->punch_date;
                            $in = \Carbon\Carbon::parse($pDate . ' ' . $record->check_in_time, $userTz);
                            $out = (!empty($record->check_out_time) && $record->check_out_time != '00:00:00') 
                                   ? \Carbon\Carbon::parse($pDate . ' ' . $record->check_out_time, $userTz) 
                                   : \Carbon\Carbon::now($userTz);
                            
                            // Use true for absolute difference
                            $total_work_minutes += $in->diffInMinutes($out, true);
                        } catch (\Exception $e) { continue; }
                    }
                }
            } else {
                if (in_array($attendance_date, $holiday_arr)) {
                    $status = 'Holiday';
                } else if (in_array($attendance_date, $leave_arr)) {
                    $status = 'On Leave';
                } else {
                    $status = 'Absent';
                }
            }

            $h = floor($total_work_minutes / 60);
            $m = $total_work_minutes % 60;

            $data[] = [
                'employee_name' => $full_name,
                'employee_id' => $employee->employee_id,
                'date' => $date->format('d M Y'),
                'day' => $day,
                'day_short' => $date->format('D'),
                'date_short' => $date->format('d'),
                'month_short' => $date->format('M'),
                'clock_in' => $clock_in_str,
                'clock_out' => $clock_out_str,
                'total_work' => $h . 'h ' . $m . 'm',
                'status' => $status,
                'initials' => strtoupper(substr($employee->first_name, 0, 1) . (isset($employee->last_name) ? substr($employee->last_name, 0, 1) : '')),
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }
}
