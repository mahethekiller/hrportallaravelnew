<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeLeaveLog
 * 
 * @property int $id
 * @property int $leave_id
 * @property int $employee_id
 * @property int $contract_id
 * @property string $casual_leave
 * @property string $medical_leave
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeLeaveLog extends Model
{
	protected $table = 'employee_leave_log';

	protected $casts = [
		'leave_id' => 'int',
		'employee_id' => 'int',
		'contract_id' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'leave_id',
		'employee_id',
		'contract_id',
		'casual_leave',
		'medical_leave',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
