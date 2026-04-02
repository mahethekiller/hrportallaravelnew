<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HourlyTemplate
 * 
 * @property int $hourly_rate_id
 * @property int $company_id
 * @property string $hourly_grade
 * @property string $hourly_rate
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class HourlyTemplate extends Model
{
	protected $table = 'hourly_templates';
	protected $primaryKey = 'hourly_rate_id';

	protected $casts = [
		'company_id' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'company_id',
		'hourly_grade',
		'hourly_rate',
		'added_by',
		'legacy_created_at'
	];
}
