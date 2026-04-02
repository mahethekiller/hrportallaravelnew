<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Intern
 * 
 * @property int $user_id
 * @property string $employee_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $date_of_birth
 * @property string $gender
 * @property int $e_status
 * @property int $department_id
 * @property int|null $company_id
 * @property string $date_of_joining
 * @property string $date_of_leaving
 * @property string $salary
 * @property string $address
 * @property string $contact_no
 * @property string $employee_source
 * @property int $ref_emp_id
 * @property string|null $legacy_created_at
 * @property int $created_by
 * @property string $category
 * @property string $address_com
 * @property string $city_temp
 * @property string $city
 * @property string $state_temp
 * @property string $state
 * @property string $pin_temp
 * @property string $pincode
 * @property string $nationality
 * @property string $religion
 * @property string $college
 * @property string $project
 * @property string $tpa
 * @property string $em_name
 * @property string $em_relation
 * @property string $em_contact
 * @property string $reporting_location
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Intern extends Model
{
	protected $table = 'interns';
	protected $primaryKey = 'user_id';

	protected $casts = [
		'e_status' => 'int',
		'department_id' => 'int',
		'company_id' => 'int',
		'ref_emp_id' => 'int',
		'created_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'first_name',
		'last_name',
		'email',
		'date_of_birth',
		'gender',
		'e_status',
		'department_id',
		'company_id',
		'date_of_joining',
		'date_of_leaving',
		'salary',
		'address',
		'contact_no',
		'employee_source',
		'ref_emp_id',
		'legacy_created_at',
		'created_by',
		'category',
		'address_com',
		'city_temp',
		'city',
		'state_temp',
		'state',
		'pin_temp',
		'pincode',
		'nationality',
		'religion',
		'college',
		'project',
		'tpa',
		'em_name',
		'em_relation',
		'em_contact',
		'reporting_location',
		'show_status'
	];
}
