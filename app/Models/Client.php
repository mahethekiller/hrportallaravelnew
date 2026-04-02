<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 * 
 * @property int $client_id
 * @property string $name
 * @property string $email
 * @property string $client_username
 * @property string $client_password
 * @property string $client_profile
 * @property string $contact_number
 * @property string $company_name
 * @property string $gender
 * @property string $website_url
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property int $country
 * @property int $is_active
 * @property string $last_logout_date
 * @property string $last_login_date
 * @property string $last_login_ip
 * @property int $is_logged_in
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Client extends Model
{
	protected $table = 'clients';
	protected $primaryKey = 'client_id';

	protected $casts = [
		'country' => 'int',
		'is_active' => 'int',
		'is_logged_in' => 'int'
	];

	protected $hidden = [
		'client_password'
	];

	protected $fillable = [
		'name',
		'email',
		'client_username',
		'client_password',
		'client_profile',
		'contact_number',
		'company_name',
		'gender',
		'website_url',
		'address_1',
		'address_2',
		'city',
		'state',
		'zipcode',
		'country',
		'is_active',
		'last_logout_date',
		'last_login_date',
		'last_login_ip',
		'is_logged_in',
		'legacy_created_at'
	];
}
