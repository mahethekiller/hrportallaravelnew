<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Meeting
 * 
 * @property int $meeting_id
 * @property int $company_id
 * @property int $employee_id
 * @property string $meeting_title
 * @property string $meeting_date
 * @property string $meeting_time
 * @property string $meeting_note
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Meeting extends Model
{
	protected $table = 'meetings';
	protected $primaryKey = 'meeting_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'meeting_title',
		'meeting_date',
		'meeting_time',
		'meeting_note',
		'legacy_created_at'
	];
}
