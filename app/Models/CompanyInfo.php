<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CompanyInfo
 * 
 * @property int $company_info_id
 * @property string $logo
 * @property string $logo_second
 * @property string $sign_in_logo
 * @property string $favicon
 * @property string $website_url
 * @property string $starting_year
 * @property string $company_name
 * @property string $company_email
 * @property string $company_contact
 * @property string $contact_person
 * @property string $email
 * @property string $phone
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property int $country
 * @property string $updated_at
 * @property Carbon|null $created_at
 *
 * @package App\Models
 */
class CompanyInfo extends Model
{
	protected $table = 'company_info';
	protected $primaryKey = 'company_info_id';

	protected $casts = [
		'country' => 'int'
	];

	protected $fillable = [
		'logo',
		'logo_second',
		'sign_in_logo',
		'favicon',
		'website_url',
		'starting_year',
		'company_name',
		'company_email',
		'company_contact',
		'contact_person',
		'email',
		'phone',
		'address_1',
		'address_2',
		'city',
		'state',
		'zipcode',
		'country'
	];
}
