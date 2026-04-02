<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 * 
 * @property int $company_id
 * @property int $type_id
 * @property string $name
 * @property string $trading_name
 * @property string $username
 * @property string $password
 * @property string $registration_no
 * @property string $government_tax
 * @property string $email
 * @property string $logo
 * @property string $contact_number
 * @property string $website_url
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property int $country
 * @property int $is_active
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Company extends Model
{
	protected $table = 'companies';
	protected $primaryKey = 'company_id';

	protected $casts = [
		'type_id' => 'int',
		'country' => 'int',
		'is_active' => 'int',
		'added_by' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'type_id',
		'name',
		'trading_name',
		'username',
		'password',
		'registration_no',
		'government_tax',
		'email',
		'logo',
		'contact_number',
		'website_url',
		'address_1',
		'address_2',
		'city',
		'state',
		'zipcode',
		'country',
		'is_active',
		'added_by',
		'legacy_created_at'
	];
}
