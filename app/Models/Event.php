<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 * 
 * @property int $event_id
 * @property int $company_id
 * @property int $employee_id
 * @property string $event_title
 * @property string $event_date
 * @property string $event_time
 * @property string $event_note
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Event extends Model
{
	protected $table = 'events';
	protected $primaryKey = 'event_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'event_title',
		'event_date',
		'event_time',
		'event_note',
		'legacy_created_at'
	];
}
