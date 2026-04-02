<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeLeave
 * 
 * @property int $leave_id
 * @property int $employee_id
 * @property int $contract_id
 * @property string $casual_leave
 * @property string $medical_leave
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeLeave extends Model
{
	protected $table = 'employee_leave';
	protected $primaryKey = 'leave_id';

	protected $casts = [
		'employee_id' => 'int',
		'contract_id' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'contract_id',
		'casual_leave',
		'medical_leave',
		'legacy_created_at'
	];
}
