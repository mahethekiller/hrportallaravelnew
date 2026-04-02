<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeLocation
 * 
 * @property int $office_location_id
 * @property int $employee_id
 * @property int $location_id
 * @property string $from_date
 * @property string $to_date
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeLocation extends Model
{
	protected $table = 'employee_location';
	protected $primaryKey = 'office_location_id';

	protected $casts = [
		'employee_id' => 'int',
		'location_id' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'location_id',
		'from_date',
		'to_date',
		'legacy_created_at'
	];
}
