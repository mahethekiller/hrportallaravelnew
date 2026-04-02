<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeWarning
 * 
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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeWarning extends Model
{
	protected $table = 'employee_warnings';
	protected $primaryKey = 'warning_id';

	protected $casts = [
		'company_id' => 'int',
		'warning_to' => 'int',
		'warning_by' => 'int',
		'warning_type_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'company_id',
		'warning_to',
		'warning_by',
		'warning_date',
		'warning_type_id',
		'subject',
		'description',
		'status',
		'legacy_created_at'
	];
}
