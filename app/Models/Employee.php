<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class Employee
 * 
 * @property int $user_id
 * @property string $employee_id
 * @property int $card_no
 * @property int $office_shift_id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $date_of_birth
 * @property string $gender
 * @property int $e_status
 * @property int $user_role_id
 * @property int $department_id
 * @property string $sub_department
 * @property int $designation_id
 * @property int $manager_id
 * @property int|null $sub_manager_id
 * @property int|null $company_id
 * @property string $salary_template
 * @property int $hourly_grade_id
 * @property int $monthly_grade_id
 * @property string $date_of_joining
 * @property string $date_of_leaving
 * @property string $marital_status
 * @property string $salary
 * @property string $address
 * @property string $profile_picture
 * @property string $profile_background
 * @property string $resume
 * @property string $skype_id
 * @property string $contact_no
 * @property string $facebook_link
 * @property string $twitter_link
 * @property string $blogger_link
 * @property string $linkdedin_link
 * @property string $google_plus_link
 * @property string $instagram_link
 * @property string $pinterest_link
 * @property string $youtube_link
 * @property string $reporting_location
 * @property string $employee_source
 * @property int $ref_emp_id
 * @property string $probation_status
 * @property string $probation_end_date
 * @property string $resign_date
 * @property string $confirmation_date
 * @property int $rejoin_emp_id
 * @property string $has_rejoined
 * @property bool $is_active
 * @property string $last_login_date
 * @property string $last_logout_date
 * @property string $last_login_ip
 * @property int $is_logged_in
 * @property int $online_status
 * @property string|null $legacy_created_at
 * @property int $created_by
 * @property string $email_personal
 * @property string $date_of_birth_doc
 * @property string $mother_tongue
 * @property string $age
 * @property string $place_of_birth
 * @property string $blood_group
 * @property string $pan_number
 * @property string $aadhar_no
 * @property string $category
 * @property string $address_com
 * @property string $earned_leave
 * @property string $casual_leave
 * @property int $other_leaves_taken_days
 * @property string $paytm_no
 * @property string $vehicle_no
 * @property string $pf_opted
 * @property string $health_ins_opted
 * @property string $official_contact_no
 * @property string $vehicle_type
 * @property string $city_temp
 * @property string $city
 * @property string $state_temp
 * @property string $state
 * @property string $pin_temp
 * @property string $pincode
 * @property string $corporate_bank_account
 * @property string|null $prob_mail_status
 * @property string $employment_type
 * @property float $experience
 * @property string $kra_doc
 * @property string|null $kpi_doc
 * @property string|null $refreshToken
 * @property int $notice_period
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Employee extends Authenticatable
{
	use HasRoles;

	protected $table = 'employees';
	protected $primaryKey = 'user_id';

	protected $casts = [
		'card_no' => 'int',
		'office_shift_id' => 'int',
		'e_status' => 'int',
		'user_role_id' => 'int',
		'department_id' => 'int',
		'sub_department_id' => 'int',
		'designation_id' => 'int',
		'manager_id' => 'int',
		'sub_manager_id' => 'int',
		'company_id' => 'int',
		'hourly_grade_id' => 'int',
		'monthly_grade_id' => 'int',
		'ref_emp_id' => 'int',
		'rejoin_emp_id' => 'int',
		'is_active' => 'bool',
		'is_logged_in' => 'int',
		'online_status' => 'int',
		'created_by' => 'int',
		'other_leaves_taken_days' => 'int',
		'experience' => 'float',
		'notice_period' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'employee_id',
		'card_no',
		'office_shift_id',
		'first_name',
		'last_name',
		'username',
		'email',
		'password',
		'date_of_birth',
		'gender',
		'e_status',
		'user_role_id',
		'department_id',
		'sub_department',
		'sub_department_id',
		'designation_id',
		'manager_id',
		'sub_manager_id',
		'company_id',
		'salary_template',
		'hourly_grade_id',
		'monthly_grade_id',
		'date_of_joining',
		'date_of_leaving',
		'marital_status',
		'salary',
		'address',
		'profile_picture',
		'profile_background',
		'resume',
		'skype_id',
		'contact_no',
		'facebook_link',
		'twitter_link',
		'blogger_link',
		'linkdedin_link',
		'google_plus_link',
		'instagram_link',
		'pinterest_link',
		'youtube_link',
		'reporting_location',
		'employee_source',
		'ref_emp_id',
		'probation_status',
		'probation_end_date',
		'resign_date',
		'confirmation_date',
		'rejoin_emp_id',
		'has_rejoined',
		'is_active',
		'last_login_date',
		'last_logout_date',
		'last_login_ip',
		'is_logged_in',
		'online_status',
		'legacy_created_at',
		'created_by',
		'email_personal',
		'date_of_birth_doc',
		'mother_tongue',
		'age',
		'place_of_birth',
		'blood_group',
		'pan_number',
		'aadhar_no',
		'category',
		'address_com',
		'earned_leave',
		'casual_leave',
		'other_leaves_taken_days',
		'paytm_no',
		'vehicle_no',
		'pf_opted',
		'health_ins_opted',
		'official_contact_no',
		'vehicle_type',
		'city_temp',
		'city',
		'state_temp',
		'state',
		'pin_temp',
		'pincode',
		'corporate_bank_account',
		'prob_mail_status',
		'employment_type',
		'experience',
		'kra_doc',
		'kpi_doc',
		'refreshToken',
		'notice_period'
	];
	public function company()
	{
		return $this->belongsTo(Company::class, 'company_id', 'company_id');
	}

	public function department()
	{
		return $this->belongsTo(Department::class, 'department_id', 'department_id');
	}

	public function designation()
	{
		return $this->belongsTo(Designation::class, 'designation_id', 'designation_id');
	}

	public function subDepartment()
	{
		return $this->belongsTo(SubDepartment::class, 'sub_department_id', 'sub_department_id');
	}
}
