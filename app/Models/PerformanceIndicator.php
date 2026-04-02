<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PerformanceIndicator
 * 
 * @property int $performance_indicator_id
 * @property int $company_id
 * @property int $designation_id
 * @property int $customer_experience
 * @property int $marketing
 * @property int $management
 * @property int $administration
 * @property int $presentation_skill
 * @property int $quality_of_work
 * @property int $efficiency
 * @property int $integrity
 * @property int $professionalism
 * @property int $team_work
 * @property int $critical_thinking
 * @property int $conflict_management
 * @property int $attendance
 * @property int $ability_to_meet_deadline
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PerformanceIndicator extends Model
{
	protected $table = 'performance_indicator';
	protected $primaryKey = 'performance_indicator_id';

	protected $casts = [
		'company_id' => 'int',
		'designation_id' => 'int',
		'customer_experience' => 'int',
		'marketing' => 'int',
		'management' => 'int',
		'administration' => 'int',
		'presentation_skill' => 'int',
		'quality_of_work' => 'int',
		'efficiency' => 'int',
		'integrity' => 'int',
		'professionalism' => 'int',
		'team_work' => 'int',
		'critical_thinking' => 'int',
		'conflict_management' => 'int',
		'attendance' => 'int',
		'ability_to_meet_deadline' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'company_id',
		'designation_id',
		'customer_experience',
		'marketing',
		'management',
		'administration',
		'presentation_skill',
		'quality_of_work',
		'efficiency',
		'integrity',
		'professionalism',
		'team_work',
		'critical_thinking',
		'conflict_management',
		'attendance',
		'ability_to_meet_deadline',
		'added_by',
		'legacy_created_at'
	];
}
