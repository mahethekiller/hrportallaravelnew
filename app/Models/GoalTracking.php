<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GoalTracking
 * 
 * @property int $tracking_id
 * @property int $company_id
 * @property int $tracking_type_id
 * @property string $start_date
 * @property string $end_date
 * @property string $subject
 * @property string $target_achiement
 * @property string $description
 * @property string $goal_progress
 * @property int $goal_status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class GoalTracking extends Model
{
	protected $table = 'goal_tracking';
	protected $primaryKey = 'tracking_id';

	protected $casts = [
		'company_id' => 'int',
		'tracking_type_id' => 'int',
		'goal_status' => 'int'
	];

	protected $fillable = [
		'company_id',
		'tracking_type_id',
		'start_date',
		'end_date',
		'subject',
		'target_achiement',
		'description',
		'goal_progress',
		'goal_status',
		'legacy_created_at'
	];
}
