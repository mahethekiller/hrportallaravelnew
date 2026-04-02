<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeResignationsLog
 * 
 * @property int $id
 * @property int $resignation_id
 * @property int $company_id
 * @property int $employee_id
 * @property string $notice_date
 * @property string $resignation_date
 * @property string $reason
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeResignationsLog extends Model
{
	protected $table = 'employee_resignations_log';

	protected $casts = [
		'resignation_id' => 'int',
		'company_id' => 'int',
		'employee_id' => 'int',
		'added_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'resignation_id',
		'company_id',
		'employee_id',
		'notice_date',
		'resignation_date',
		'reason',
		'added_by',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
