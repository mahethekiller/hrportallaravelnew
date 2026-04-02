<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeSalary
 * 
 * @property int $id
 * @property int $employee_id
 * @property string $old_salary
 * @property string $new_salary
 * @property string $appraisal_date
 * @property int $added_by
 * @property string $added_date
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeSalary extends Model
{
	protected $table = 'employee_salary';

	protected $casts = [
		'employee_id' => 'int',
		'added_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'old_salary',
		'new_salary',
		'appraisal_date',
		'added_by',
		'added_date',
		'show_status'
	];
}
