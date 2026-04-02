<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeesTemp
 * 
 * @property int $id
 * @property string|null $employee_id
 * @property string $basic_info
 * @property string $converted_to_emp
 * @property int $show_status
 * @property string $added_date
 * @property string $last_updated
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeesTemp extends Model
{
	protected $table = 'employees_temp';

	protected $casts = [
		'show_status' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'basic_info',
		'converted_to_emp',
		'show_status',
		'added_date',
		'last_updated'
	];
}
