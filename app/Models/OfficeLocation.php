<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OfficeLocation
 * 
 * @property int $location_id
 * @property int $company_id
 * @property int $location_head
 * @property int $location_manager
 * @property string $location_name
 * @property string $email
 * @property string $phone
 * @property string $fax
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property int $country
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OfficeLocation extends Model
{
	protected $table = 'office_location';
	protected $primaryKey = 'location_id';

	protected $casts = [
		'company_id' => 'int',
		'location_head' => 'int',
		'location_manager' => 'int',
		'country' => 'int',
		'added_by' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'company_id',
		'location_head',
		'location_manager',
		'location_name',
		'email',
		'phone',
		'fax',
		'address_1',
		'address_2',
		'city',
		'state',
		'zipcode',
		'country',
		'added_by',
		'legacy_created_at',
		'status'
	];
}
