<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeTermination
 * 
 * @property int $termination_id
 * @property int $company_id
 * @property int $employee_id
 * @property int $terminated_by
 * @property int $termination_type_id
 * @property string $termination_date
 * @property string $notice_date
 * @property string $description
 * @property int $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeTermination extends Model
{
	protected $table = 'employee_terminations';
	protected $primaryKey = 'termination_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'terminated_by' => 'int',
		'termination_type_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'terminated_by',
		'termination_type_id',
		'termination_date',
		'notice_date',
		'description',
		'status',
		'legacy_created_at'
	];
}
