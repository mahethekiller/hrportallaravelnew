<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TasksAttachment
 * 
 * @property int $task_attachment_id
 * @property int $task_id
 * @property int $upload_by
 * @property string $file_title
 * @property string $file_description
 * @property string $attachment_file
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TasksAttachment extends Model
{
	protected $table = 'tasks_attachment';
	protected $primaryKey = 'task_attachment_id';
	public $incrementing = false;

	protected $casts = [
		'task_attachment_id' => 'int',
		'task_id' => 'int',
		'upload_by' => 'int'
	];

	protected $fillable = [
		'task_id',
		'upload_by',
		'file_title',
		'file_description',
		'attachment_file',
		'legacy_created_at'
	];
}
