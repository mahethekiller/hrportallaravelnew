<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Holiday
 * 
 * @property int $holiday_id
 * @property int $company_id
 * @property string $event_name
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property bool $is_publish
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Holiday extends Model
{
	protected $table = 'holidays';
	protected $primaryKey = 'holiday_id';

	protected $casts = [
		'company_id' => 'int',
		'is_publish' => 'bool'
	];

	protected $fillable = [
		'company_id',
		'event_name',
		'description',
		'start_date',
		'end_date',
		'is_publish',
		'legacy_created_at'
	];
}
