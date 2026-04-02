<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PipEmployee
 * 
 * @property int $id
 * @property int $employee_id
 * @property int $pip_status
 * @property string $from_date
 * @property string $to_date
 * @property string $pip_message
 * @property string $added_date
 * @property int $added_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PipEmployee extends Model
{
	protected $table = 'pip_employees';

	protected $casts = [
		'employee_id' => 'int',
		'pip_status' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'pip_status',
		'from_date',
		'to_date',
		'pip_message',
		'added_date',
		'added_by'
	];
}
