<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeTravel
 * 
 * @property int $travel_id
 * @property int $company_id
 * @property int $employee_id
 * @property string $start_date
 * @property string $end_date
 * @property string $visit_purpose
 * @property string $visit_place
 * @property int|null $travel_mode
 * @property int|null $arrangement_type
 * @property string $expected_budget
 * @property string $actual_budget
 * @property string $date
 * @property string|null $from_p
 * @property string|null $to_p
 * @property string|null $from_reading
 * @property string|null $to_reading
 * @property string|null $distance
 * @property string $cost
 * @property string $description
 * @property int $status
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeTravel extends Model
{
	protected $table = 'employee_travels';
	protected $primaryKey = 'travel_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'travel_mode' => 'int',
		'arrangement_type' => 'int',
		'status' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'start_date',
		'end_date',
		'visit_purpose',
		'visit_place',
		'travel_mode',
		'arrangement_type',
		'expected_budget',
		'actual_budget',
		'date',
		'from_p',
		'to_p',
		'from_reading',
		'to_reading',
		'distance',
		'cost',
		'description',
		'status',
		'added_by',
		'legacy_created_at'
	];
}
