<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProjectsBug
 * 
 * @property int $bug_id
 * @property int $project_id
 * @property int $user_id
 * @property string $attachment_file
 * @property string $title
 * @property bool $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ProjectsBug extends Model
{
	protected $table = 'projects_bugs';
	protected $primaryKey = 'bug_id';

	protected $casts = [
		'project_id' => 'int',
		'user_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'project_id',
		'user_id',
		'attachment_file',
		'title',
		'status',
		'legacy_created_at'
	];
}
