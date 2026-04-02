<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JobApplication
 * 
 * @property int $application_id
 * @property int $job_id
 * @property string $candidate_name
 * @property string $email
 * @property string $gender
 * @property string $experience
 * @property int $user_id
 * @property string $message
 * @property string $job_resume
 * @property string|null $source
 * @property string|null $sub_source
 * @property string $referral_name
 * @property string|null $date_cv_sourced
 * @property int $company
 * @property int $department_id
 * @property string|null $current_location
 * @property string|null $current_package
 * @property string|null $expected_package
 * @property string|null $contact_no
 * @property string|null $notice_period
 * @property string|null $change_reason
 * @property string|null $current_company
 * @property string $application_status
 * @property string|null $application_remarks
 * @property string $hr_remarks
 * @property string $covid_status
 * @property string|null $profile_picture
 * @property string|null $legacy_created_at
 * @property int $added_by
 * @property int|null $updated_by
 * @property string|null $updated_date
 * @property int $show_status
 * @property string $remarks
 * @property string $reason_to_leave
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class JobApplication extends Model
{
	protected $table = 'job_applications';
	protected $primaryKey = 'application_id';

	protected $casts = [
		'job_id' => 'int',
		'user_id' => 'int',
		'company' => 'int',
		'department_id' => 'int',
		'added_by' => 'int',
		'updated_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'job_id',
		'candidate_name',
		'email',
		'gender',
		'experience',
		'user_id',
		'message',
		'job_resume',
		'source',
		'sub_source',
		'referral_name',
		'date_cv_sourced',
		'company',
		'department_id',
		'current_location',
		'current_package',
		'expected_package',
		'contact_no',
		'notice_period',
		'change_reason',
		'current_company',
		'application_status',
		'application_remarks',
		'hr_remarks',
		'covid_status',
		'profile_picture',
		'legacy_created_at',
		'added_by',
		'updated_by',
		'updated_date',
		'show_status',
		'remarks',
		'reason_to_leave'
	];
}
