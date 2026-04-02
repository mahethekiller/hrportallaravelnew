<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LeaveApplication
 * 
 * @property int $leave_id
 * @property int $company_id
 * @property int $employee_id
 * @property int|null $manager_id
 * @property int $leave_type_id
 * @property string $start_duration
 * @property string $from_date
 * @property string $to_date
 * @property string $end_duration
 * @property string $applied_on
 * @property float $casual_deducted
 * @property float $earned_deducted
 * @property string $reason
 * @property string $remarks
 * @property bool $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LeaveApplication extends Model
{
	protected $table = 'leave_applications';
	protected $primaryKey = 'leave_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'manager_id' => 'int',
		'leave_type_id' => 'int',
		'casual_deducted' => 'float',
		'earned_deducted' => 'float',
		'status' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'manager_id',
		'leave_type_id',
		'start_duration',
		'from_date',
		'to_date',
		'end_duration',
		'applied_on',
		'casual_deducted',
		'earned_deducted',
		'reason',
		'remarks',
		'status',
		'legacy_created_at'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'employee_id', 'user_id');
	}

	public function leaveType()
	{
		return $this->belongsTo(LeaveType::class, 'leave_type_id', 'leave_type_id');
	}
}
