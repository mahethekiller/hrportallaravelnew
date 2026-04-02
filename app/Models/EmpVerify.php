<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmpVerify
 * 
 * @property int $id
 * @property int $userid
 * @property string $emp_code
 * @property string $designation
 * @property string $organization
 * @property string $manager_name
 * @property string $manager_email
 * @property string $manager_phone
 * @property string $hr_name
 * @property string $hr_email
 * @property string $hr_phone
 * @property string|null $organization2
 * @property string|null $manager_name2
 * @property string|null $manager_email2
 * @property string|null $manager_phone2
 * @property string|null $hr_name2
 * @property string|null $hr_email2
 * @property string|null $date_of_leaving
 * @property string|null $date_of_joining
 * @property string|null $hr_phone2
 * @property string $reason_to_leave
 * @property string $time_duration
 * @property string $exit_formalities
 * @property string $exit_formalities_desc
 * @property string $offer_letter
 * @property string $relieving_letter
 * @property string $increment_letter
 * @property string $experience_letter
 * @property int $designation2
 * @property string|null $emp_code2
 * @property string|null $date_of_leaving2
 * @property string|null $date_of_joining2
 * @property string|null $reason_to_leave2
 * @property string|null $exit_formalities2
 * @property string|null $exit_formalities_desc2
 * @property string $letter_of_authentication
 * @property string $comments
 * @property string $verification_status
 * @property string $added_by
 * @property string $added_date
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmpVerify extends Model
{
	protected $table = 'emp_verify';

	protected $casts = [
		'userid' => 'int',
		'designation2' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'userid',
		'emp_code',
		'designation',
		'organization',
		'manager_name',
		'manager_email',
		'manager_phone',
		'hr_name',
		'hr_email',
		'hr_phone',
		'organization2',
		'manager_name2',
		'manager_email2',
		'manager_phone2',
		'hr_name2',
		'hr_email2',
		'date_of_leaving',
		'date_of_joining',
		'hr_phone2',
		'reason_to_leave',
		'time_duration',
		'exit_formalities',
		'exit_formalities_desc',
		'offer_letter',
		'relieving_letter',
		'increment_letter',
		'experience_letter',
		'designation2',
		'emp_code2',
		'date_of_leaving2',
		'date_of_joining2',
		'reason_to_leave2',
		'exit_formalities2',
		'exit_formalities_desc2',
		'letter_of_authentication',
		'comments',
		'verification_status',
		'added_by',
		'added_date',
		'show_status'
	];
}
