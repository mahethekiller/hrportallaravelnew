<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeWorkExperienceLog
 * 
 * @property int $id
 * @property int $work_experience_id
 * @property int $employee_id
 * @property string $company_name
 * @property string $from_date
 * @property string $to_date
 * @property string $post
 * @property string $description
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeWorkExperienceLog extends Model
{
	protected $table = 'employee_work_experience_log';

	protected $casts = [
		'work_experience_id' => 'int',
		'employee_id' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'work_experience_id',
		'employee_id',
		'company_name',
		'from_date',
		'to_date',
		'post',
		'description',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
