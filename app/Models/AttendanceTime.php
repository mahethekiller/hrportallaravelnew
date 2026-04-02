<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttendanceTime
 * 
 * @property int $time_attendance_id
 * @property int $employee_id
 * @property string $attendance_date
 * @property string $clock_in
 * @property string $clock_in_ip_address
 * @property string $clock_out
 * @property string $clock_out_ip_address
 * @property string $clock_in_out
 * @property string $time_late
 * @property string $early_leaving
 * @property string $overtime
 * @property string $total_work
 * @property string $total_rest
 * @property string $attendance_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AttendanceTime extends Model
{
	protected $table = 'attendance_time';
	protected $primaryKey = 'time_attendance_id';

	protected $casts = [
		'employee_id' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'attendance_date',
		'clock_in',
		'clock_in_ip_address',
		'clock_out',
		'clock_out_ip_address',
		'clock_in_out',
		'time_late',
		'early_leaving',
		'overtime',
		'total_work',
		'total_rest',
		'attendance_status'
	];
}
