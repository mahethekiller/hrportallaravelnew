<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeShiftLog
 * 
 * @property int $id
 * @property int $emp_shift_id
 * @property int $employee_id
 * @property int $shift_id
 * @property string $from_date
 * @property string $to_date
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeShiftLog extends Model
{
	protected $table = 'employee_shift_log';

	protected $casts = [
		'emp_shift_id' => 'int',
		'employee_id' => 'int',
		'shift_id' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'emp_shift_id',
		'employee_id',
		'shift_id',
		'from_date',
		'to_date',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
