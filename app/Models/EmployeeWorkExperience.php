<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeWorkExperience
 * 
 * @property int $work_experience_id
 * @property int|null $employee_id
 * @property int|null $interview_id
 * @property string $company_name
 * @property string $from_date
 * @property string $to_date
 * @property string $post
 * @property string $description
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeWorkExperience extends Model
{
	protected $table = 'employee_work_experience';
	protected $primaryKey = 'work_experience_id';

	protected $casts = [
		'employee_id' => 'int',
		'interview_id' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'interview_id',
		'company_name',
		'from_date',
		'to_date',
		'post',
		'description',
		'legacy_created_at'
	];
}
