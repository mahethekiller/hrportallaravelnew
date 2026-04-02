<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * 
 * @property int $task_id
 * @property int $company_id
 * @property int $project_id
 * @property int $created_by
 * @property string $task_name
 * @property string $assigned_to
 * @property string $start_date
 * @property string $end_date
 * @property string $task_hour
 * @property string $task_progress
 * @property string $description
 * @property int $task_status
 * @property string $task_note
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Task extends Model
{
	protected $table = 'tasks';
	protected $primaryKey = 'task_id';

	protected $casts = [
		'company_id' => 'int',
		'project_id' => 'int',
		'created_by' => 'int',
		'task_status' => 'int'
	];

	protected $fillable = [
		'company_id',
		'project_id',
		'created_by',
		'task_name',
		'assigned_to',
		'start_date',
		'end_date',
		'task_hour',
		'task_progress',
		'description',
		'task_status',
		'task_note',
		'legacy_created_at'
	];
}
