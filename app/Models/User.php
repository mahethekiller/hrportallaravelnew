<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $user_id
 * @property string $user_role
 * @property string $first_name
 * @property string $last_name
 * @property string $company_name
 * @property string $company_logo
 * @property int $user_type
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $profile_photo
 * @property string $profile_background
 * @property string $contact_number
 * @property string $gender
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property int $country
 * @property string $last_login_date
 * @property string $last_login_ip
 * @property int $is_logged_in
 * @property int $is_active
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';
	protected $primaryKey = 'user_id';
	public $incrementing = false;

	protected $casts = [
		'user_id' => 'int',
		'user_type' => 'int',
		'country' => 'int',
		'is_logged_in' => 'int',
		'is_active' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'user_role',
		'first_name',
		'last_name',
		'company_name',
		'company_logo',
		'user_type',
		'email',
		'username',
		'password',
		'profile_photo',
		'profile_background',
		'contact_number',
		'gender',
		'address_1',
		'address_2',
		'city',
		'state',
		'zipcode',
		'country',
		'last_login_date',
		'last_login_ip',
		'is_logged_in',
		'is_active',
		'legacy_created_at'
	];
}
