<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeExit
 * 
 * @property int $exit_id
 * @property int $company_id
 * @property int $employee_id
 * @property string $exit_date
 * @property int $exit_type_id
 * @property int $exit_interview
 * @property int $is_inactivate_account
 * @property string $reason
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeExit extends Model
{
	protected $table = 'employee_exit';
	protected $primaryKey = 'exit_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'exit_type_id' => 'int',
		'exit_interview' => 'int',
		'is_inactivate_account' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'exit_date',
		'exit_type_id',
		'exit_interview',
		'is_inactivate_account',
		'reason',
		'added_by',
		'legacy_created_at'
	];
}
