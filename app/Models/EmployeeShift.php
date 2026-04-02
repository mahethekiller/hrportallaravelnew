<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeShift
 * 
 * @property int $emp_shift_id
 * @property int $employee_id
 * @property int $shift_id
 * @property string $from_date
 * @property string $to_date
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeShift extends Model
{
	protected $table = 'employee_shift';
	protected $primaryKey = 'emp_shift_id';

	protected $casts = [
		'employee_id' => 'int',
		'shift_id' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'shift_id',
		'from_date',
		'to_date',
		'legacy_created_at'
	];
}
