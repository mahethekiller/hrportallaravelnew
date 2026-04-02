<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeTransferLog
 * 
 * @property int $id
 * @property int $transfer_id
 * @property int $company_id
 * @property int $employee_id
 * @property string $transfer_date
 * @property int $transfer_department
 * @property int $transfer_location
 * @property string $description
 * @property int $status
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeTransferLog extends Model
{
	protected $table = 'employee_transfer_log';

	protected $casts = [
		'transfer_id' => 'int',
		'company_id' => 'int',
		'employee_id' => 'int',
		'transfer_department' => 'int',
		'transfer_location' => 'int',
		'status' => 'int',
		'added_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'transfer_id',
		'company_id',
		'employee_id',
		'transfer_date',
		'transfer_department',
		'transfer_location',
		'description',
		'status',
		'added_by',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
