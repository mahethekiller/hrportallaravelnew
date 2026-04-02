<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmpTodayAttendance
 * 
 * @property int $id
 * @property int $card_no
 * @property Carbon $punch_date
 * @property Carbon $check_in_datetime
 * @property Carbon $check_out_datetime
 * @property int $badgenumber
 * @property string $check_in_time
 * @property string $check_out_time
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmpTodayAttendance extends Model
{
	protected $table = 'emp_today_attendance';

	protected $casts = [
		'card_no' => 'int',
		'punch_date' => 'datetime',
		'check_in_datetime' => 'datetime',
		'check_out_datetime' => 'datetime',
		'badgenumber' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'card_no',
		'punch_date',
		'check_in_datetime',
		'check_out_datetime',
		'badgenumber',
		'check_in_time',
		'check_out_time',
		'show_status'
	];
}
