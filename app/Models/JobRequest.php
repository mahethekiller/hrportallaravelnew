<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JobRequest
 * 
 * @property int $request_id
 * @property string $post_name
 * @property int $vacancies
 * @property int $company_id
 * @property int $department_id
 * @property string $team
 * @property string $position_level
 * @property string $min_experience
 * @property string $max_experience
 * @property string $job_role
 * @property string $min_salary
 * @property string $max_salary
 * @property string $ctc_budget
 * @property string $shift_timings
 * @property string $timing_details
 * @property string $work_days
 * @property string $priority
 * @property int $interview_rounds
 * @property string $interview_round_details
 * @property string $questionare
 * @property string $competitor
 * @property string $profile_description
 * @property string|null $project_description
 * @property string $certification
 * @property string $education
 * @property string $skills
 * @property string $gender_preference
 * @property string $description
 * @property string $added_by
 * @property string $added_date
 * @property string|null $updated_date
 * @property string|null $updated_by
 * @property int $approve_status
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class JobRequest extends Model
{
	protected $table = 'job_requests';
	protected $primaryKey = 'request_id';

	protected $casts = [
		'vacancies' => 'int',
		'company_id' => 'int',
		'department_id' => 'int',
		'interview_rounds' => 'int',
		'approve_status' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'post_name',
		'vacancies',
		'company_id',
		'department_id',
		'team',
		'position_level',
		'min_experience',
		'max_experience',
		'job_role',
		'min_salary',
		'max_salary',
		'ctc_budget',
		'shift_timings',
		'timing_details',
		'work_days',
		'priority',
		'interview_rounds',
		'interview_round_details',
		'questionare',
		'competitor',
		'profile_description',
		'project_description',
		'certification',
		'education',
		'skills',
		'gender_preference',
		'description',
		'added_by',
		'added_date',
		'updated_date',
		'updated_by',
		'approve_status',
		'show_status'
	];
}
