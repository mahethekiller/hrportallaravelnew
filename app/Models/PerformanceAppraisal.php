<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PerformanceAppraisal
 * 
 * @property int $performance_appraisal_id
 * @property int $company_id
 * @property int $employee_id
 * @property int|null $manager_id
 * @property string $appraisal_year_month
 * @property int|null $customer_experience
 * @property int|null $marketing
 * @property int|null $management
 * @property int|null $administration
 * @property int|null $presentation_skill
 * @property int|null $quality_of_work
 * @property int|null $efficiency
 * @property int|null $integrity
 * @property int|null $professionalism
 * @property int|null $team_work
 * @property int|null $critical_thinking
 * @property int|null $conflict_management
 * @property int|null $attendance
 * @property int|null $attendance_emp
 * @property int|null $job_knowledge
 * @property int|null $job_knowledge_emp
 * @property int|null $quality_of_work_emp
 * @property int|null $teamwork
 * @property int|null $teamwork_emp
 * @property int|null $communication
 * @property int|null $communication_emp
 * @property int|null $problem_solving
 * @property int|null $problem_solving_emp
 * @property int|null $ability_to_meet_deadline
 * @property string $remarks
 * @property string|null $remarks_emp
 * @property string|null $area_strength
 * @property string|null $area_imp
 * @property string|null $future_goals
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property string|null $manager_update_date
 * @property string|null $emp_update_date
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PerformanceAppraisal extends Model
{
	protected $table = 'performance_appraisal';
	protected $primaryKey = 'performance_appraisal_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'manager_id' => 'int',
		'customer_experience' => 'int',
		'marketing' => 'int',
		'management' => 'int',
		'administration' => 'int',
		'presentation_skill' => 'int',
		'quality_of_work' => 'int',
		'efficiency' => 'int',
		'integrity' => 'int',
		'professionalism' => 'int',
		'team_work' => 'int',
		'critical_thinking' => 'int',
		'conflict_management' => 'int',
		'attendance' => 'int',
		'attendance_emp' => 'int',
		'job_knowledge' => 'int',
		'job_knowledge_emp' => 'int',
		'quality_of_work_emp' => 'int',
		'teamwork' => 'int',
		'teamwork_emp' => 'int',
		'communication' => 'int',
		'communication_emp' => 'int',
		'problem_solving' => 'int',
		'problem_solving_emp' => 'int',
		'ability_to_meet_deadline' => 'int',
		'added_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'manager_id',
		'appraisal_year_month',
		'customer_experience',
		'marketing',
		'management',
		'administration',
		'presentation_skill',
		'quality_of_work',
		'efficiency',
		'integrity',
		'professionalism',
		'team_work',
		'critical_thinking',
		'conflict_management',
		'attendance',
		'attendance_emp',
		'job_knowledge',
		'job_knowledge_emp',
		'quality_of_work_emp',
		'teamwork',
		'teamwork_emp',
		'communication',
		'communication_emp',
		'problem_solving',
		'problem_solving_emp',
		'ability_to_meet_deadline',
		'remarks',
		'remarks_emp',
		'area_strength',
		'area_imp',
		'future_goals',
		'added_by',
		'legacy_created_at',
		'manager_update_date',
		'emp_update_date',
		'show_status'
	];
}
