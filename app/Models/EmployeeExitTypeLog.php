<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeExitTypeLog
 * 
 * @property int $id
 * @property int $exit_type_id
 * @property int $company_id
 * @property string $type
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeExitTypeLog extends Model
{
	protected $table = 'employee_exit_type_log';

	protected $casts = [
		'exit_type_id' => 'int',
		'company_id' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'exit_type_id',
		'company_id',
		'type',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
