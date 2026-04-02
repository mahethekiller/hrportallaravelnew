<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Performance
 * 
 * @property int $id
 * @property int|null $employee_id
 * @property int|null $manager_id
 * @property int|null $job_knowledge
 * @property int|null $quality_of_work
 * @property int|null $teamwork
 * @property int|null $comm_skills
 * @property int|null $attendance
 * @property int|null $problem_solving
 * @property string|null $comments
 * @property string|null $strength_areas
 * @property string|null $improvement_areas
 * @property string|null $goals_dev_plans
 * @property string|null $emp_comments
 * @property int|null $manager_acceptance
 * @property int|null $emp_acceptance
 * @property string|null $added_date
 * @property string|null $updated_date
 * @property int|null $updated_by
 * @property int|null $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Performance extends Model
{
	protected $table = 'performance';

	protected $casts = [
		'employee_id' => 'int',
		'manager_id' => 'int',
		'job_knowledge' => 'int',
		'quality_of_work' => 'int',
		'teamwork' => 'int',
		'comm_skills' => 'int',
		'attendance' => 'int',
		'problem_solving' => 'int',
		'manager_acceptance' => 'int',
		'emp_acceptance' => 'int',
		'updated_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'manager_id',
		'job_knowledge',
		'quality_of_work',
		'teamwork',
		'comm_skills',
		'attendance',
		'problem_solving',
		'comments',
		'strength_areas',
		'improvement_areas',
		'goals_dev_plans',
		'emp_comments',
		'manager_acceptance',
		'emp_acceptance',
		'added_date',
		'updated_date',
		'updated_by',
		'show_status'
	];
}
