<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeWarningsLog
 * 
 * @property int $id
 * @property int $warning_id
 * @property int $company_id
 * @property int $warning_to
 * @property int $warning_by
 * @property string $warning_date
 * @property int $warning_type_id
 * @property string $subject
 * @property string $description
 * @property int $status
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeWarningsLog extends Model
{
	protected $table = 'employee_warnings_log';

	protected $casts = [
		'warning_id' => 'int',
		'company_id' => 'int',
		'warning_to' => 'int',
		'warning_by' => 'int',
		'warning_type_id' => 'int',
		'status' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'warning_id',
		'company_id',
		'warning_to',
		'warning_by',
		'warning_date',
		'warning_type_id',
		'subject',
		'description',
		'status',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
