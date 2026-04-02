<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InterviewReschedule
 * 
 * @property int $reschedule_id
 * @property string $interview_date
 * @property string $interview_time
 * @property string $interview_place
 * @property string $interview_status
 * @property string $description
 * @property string $update_date
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class InterviewReschedule extends Model
{
	protected $table = 'interview_reschedule';
	protected $primaryKey = 'reschedule_id';

	protected $casts = [
		'updated_by' => 'int'
	];

	protected $fillable = [
		'interview_date',
		'interview_time',
		'interview_place',
		'interview_status',
		'description',
		'update_date',
		'updated_by'
	];
}
