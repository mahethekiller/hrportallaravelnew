<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeLocationLog
 * 
 * @property int $id
 * @property int $office_location_id
 * @property int $employee_id
 * @property int $location_id
 * @property string $from_date
 * @property string $to_date
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeLocationLog extends Model
{
	protected $table = 'employee_location_log';

	protected $casts = [
		'office_location_id' => 'int',
		'employee_id' => 'int',
		'location_id' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'office_location_id',
		'employee_id',
		'location_id',
		'from_date',
		'to_date',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
