<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeQualificationLog
 * 
 * @property int $id
 * @property int $qualification_id
 * @property int $employee_id
 * @property string $name
 * @property int $education_level_id
 * @property string $from_year
 * @property int $language_id
 * @property string $to_year
 * @property string $skill_id
 * @property string $description
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeQualificationLog extends Model
{
	protected $table = 'employee_qualification_log';

	protected $casts = [
		'qualification_id' => 'int',
		'employee_id' => 'int',
		'education_level_id' => 'int',
		'language_id' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'qualification_id',
		'employee_id',
		'name',
		'education_level_id',
		'from_year',
		'language_id',
		'to_year',
		'skill_id',
		'description',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
