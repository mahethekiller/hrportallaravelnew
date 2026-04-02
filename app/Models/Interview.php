<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Interview
 * 
 * @property int $job_interview_id
 * @property string $candidate_name
 * @property string $email
 * @property string $contact_no
 * @property string $resume
 * @property string|null $source
 * @property string $sub_source
 * @property string $referral_name
 * @property string $date_cv_sourced
 * @property string $experience
 * @property int $company_id
 * @property int $department_id
 * @property string $current_location
 * @property string $current_package
 * @property string|null $job_location
 * @property string $expected_package
 * @property string $notice_period
 * @property string $change_reason
 * @property string $current_company
 * @property int $job_id
 * @property string $interviewers_id
 * @property string $interview_mode
 * @property string $interview_place
 * @property string $interview_date
 * @property string|null $interview_date2
 * @property string|null $new_date
 * @property string $next_round_date
 * @property string $interview_time
 * @property string $description
 * @property string $application_remarks
 * @property string $status
 * @property string $offer_status
 * @property int $salary_template_id
 * @property int $convert_to_employee
 * @property int|null $employee_id
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
class Interview extends Model
{
	protected $table = 'interviews';
	protected $primaryKey = 'job_interview_id';

	protected $casts = [
		'company_id' => 'int',
		'department_id' => 'int',
		'job_id' => 'int',
		'salary_template_id' => 'int',
		'convert_to_employee' => 'int',
		'employee_id' => 'int',
		'added_by' => 'int',
		'updated_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'candidate_name',
		'email',
		'contact_no',
		'resume',
		'source',
		'sub_source',
		'referral_name',
		'date_cv_sourced',
		'experience',
		'company_id',
		'department_id',
		'current_location',
		'current_package',
		'job_location',
		'expected_package',
		'notice_period',
		'change_reason',
		'current_company',
		'job_id',
		'interviewers_id',
		'interview_mode',
		'interview_place',
		'interview_date',
		'interview_date2',
		'new_date',
		'next_round_date',
		'interview_time',
		'description',
		'application_remarks',
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
