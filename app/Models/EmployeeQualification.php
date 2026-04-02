<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeQualification
 * 
 * @property int $qualification_id
 * @property int|null $employee_id
 * @property int|null $interview_id
 * @property string $name
 * @property int $education_level_id
 * @property string $from_year
 * @property int $language_id
 * @property string $to_year
 * @property string $skill_id
 * @property string $specialization
 * @property string $description
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeQualification extends Model
{
	protected $table = 'employee_qualification';
	protected $primaryKey = 'qualification_id';

	protected $casts = [
		'employee_id' => 'int',
		'interview_id' => 'int',
		'education_level_id' => 'int',
		'language_id' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'interview_id',
		'name',
		'education_level_id',
		'from_year',
		'language_id',
		'to_year',
		'skill_id',
		'specialization',
		'description',
		'legacy_created_at'
	];
}
