<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProjectsDiscussion
 * 
 * @property int $discussion_id
 * @property int $project_id
 * @property int $user_id
 * @property int $client_id
 * @property string $attachment_file
 * @property string $message
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ProjectsDiscussion extends Model
{
	protected $table = 'projects_discussion';
	protected $primaryKey = 'discussion_id';

	protected $casts = [
		'project_id' => 'int',
		'user_id' => 'int',
		'client_id' => 'int'
	];

	protected $fillable = [
		'project_id',
		'user_id',
		'client_id',
		'attachment_file',
		'message',
		'legacy_created_at'
	];
}
