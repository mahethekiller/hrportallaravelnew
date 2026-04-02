<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeContractLog
 * 
 * @property int $id
 * @property int $contract_id
 * @property int $employee_id
 * @property int $contract_type_id
 * @property string $from_date
 * @property int $designation_id
 * @property string $title
 * @property string $to_date
 * @property string $description
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeContractLog extends Model
{
	protected $table = 'employee_contract_log';

	protected $casts = [
		'contract_id' => 'int',
		'employee_id' => 'int',
		'contract_type_id' => 'int',
		'designation_id' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'contract_id',
		'employee_id',
		'contract_type_id',
		'from_date',
		'designation_id',
		'title',
		'to_date',
		'description',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
