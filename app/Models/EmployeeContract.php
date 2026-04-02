<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeContract
 * 
 * @property int $contract_id
 * @property int $employee_id
 * @property int $contract_type_id
 * @property string $from_date
 * @property int $designation_id
 * @property string $title
 * @property string $to_date
 * @property string $description
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeContract extends Model
{
	protected $table = 'employee_contract';
	protected $primaryKey = 'contract_id';

	protected $casts = [
		'employee_id' => 'int',
		'contract_type_id' => 'int',
		'designation_id' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'contract_type_id',
		'from_date',
		'designation_id',
		'title',
		'to_date',
		'description',
		'legacy_created_at'
	];
}
