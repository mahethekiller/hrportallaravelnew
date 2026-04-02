<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QualificationEducationLevel
 * 
 * @property int $education_level_id
 * @property int $company_id
 * @property string $name
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class QualificationEducationLevel extends Model
{
	protected $table = 'qualification_education_level';
	protected $primaryKey = 'education_level_id';

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'name',
		'legacy_created_at'
	];
}
