<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeContact
 * 
 * @property int $contact_id
 * @property int $employee_id
 * @property string $relation
 * @property int $is_primary
 * @property int $is_dependent
 * @property string $contact_name
 * @property string $work_phone
 * @property string $work_phone_extension
 * @property string $mobile_phone
 * @property string $home_phone
 * @property string $work_email
 * @property string $personal_email
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $country
 * @property string|null $age
 * @property string|null $occupation
 * @property string|null $qualification
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeContact extends Model
{
	protected $table = 'employee_contacts';
	protected $primaryKey = 'contact_id';

	protected $casts = [
		'employee_id' => 'int',
		'is_primary' => 'int',
		'is_dependent' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'relation',
		'is_primary',
		'is_dependent',
		'contact_name',
		'work_phone',
		'work_phone_extension',
		'mobile_phone',
		'home_phone',
		'work_email',
		'personal_email',
		'address_1',
		'address_2',
		'city',
		'state',
		'zipcode',
		'country',
		'age',
		'occupation',
		'qualification',
		'legacy_created_at'
	];
}
