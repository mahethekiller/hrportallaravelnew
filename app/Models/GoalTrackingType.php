<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GoalTrackingType
 * 
 * @property int $tracking_type_id
 * @property int $company_id
 * @property string $type_name
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class GoalTrackingType extends Model
{
	protected $table = 'goal_tracking_type';
	protected $primaryKey = 'tracking_type_id';

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'type_name',
		'legacy_created_at'
	];
}
