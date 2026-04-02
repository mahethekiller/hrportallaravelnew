<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JobInterviewsLog
 * 
 * @property int $job_interview_id
 * @property int $id
 * @property int $job_id
 * @property int $application_id
 * @property string $interviewers_id
 * @property string $interview_mode
 * @property string $interview_place
 * @property string $interview_date
 * @property string|null $interview_date2
 * @property string|null $new_date
 * @property string $next_round_date
 * @property string $interview_time
 * @property string $interviewees_id
 * @property string $description
 * @property string $remarks
 * @property string $status
 * @property string $offer_status
 * @property int $salary_template_id
 * @property int $convert_to_employee
 * @property string|null $employee_id
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property string $updated_date
 * @property int $updated_by
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class JobInterviewsLog extends Model
{
	protected $table = 'job_interviews_log';

	protected $casts = [
		'job_interview_id' => 'int',
		'job_id' => 'int',
		'application_id' => 'int',
		'salary_template_id' => 'int',
		'convert_to_employee' => 'int',
		'added_by' => 'int',
		'updated_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'job_interview_id',
		'job_id',
		'application_id',
		'interviewers_id',
		'interview_mode',
		'interview_place',
		'interview_date',
		'interview_date2',
		'new_date',
		'next_round_date',
		'interview_time',
		'interviewees_id',
		'description',
		'remarks',
		'status',
		'offer_status',
		'salary_template_id',
		'convert_to_employee',
		'employee_id',
		'added_by',
		'legacy_created_at',
		'updated_date',
		'updated_by',
		'show_status'
	];
}
