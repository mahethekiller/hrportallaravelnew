<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeExitType
 * 
 * @property int $exit_type_id
 * @property int $company_id
 * @property string $type
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeExitType extends Model
{
	protected $table = 'employee_exit_type';
	protected $primaryKey = 'exit_type_id';

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'type',
		'legacy_created_at'
	];
}
