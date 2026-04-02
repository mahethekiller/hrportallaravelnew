<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QualificationSkill
 * 
 * @property int $skill_id
 * @property int $company_id
 * @property string $name
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class QualificationSkill extends Model
{
	protected $table = 'qualification_skill';
	protected $primaryKey = 'skill_id';

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'name',
		'legacy_created_at'
	];
}
