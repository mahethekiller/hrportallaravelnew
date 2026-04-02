<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TasksComment
 * 
 * @property int $comment_id
 * @property int $task_id
 * @property int $user_id
 * @property string $task_comments
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TasksComment extends Model
{
	protected $table = 'tasks_comments';
	protected $primaryKey = 'comment_id';
	public $incrementing = false;

	protected $casts = [
		'comment_id' => 'int',
		'task_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'task_id',
		'user_id',
		'task_comments',
		'legacy_created_at'
	];
}
