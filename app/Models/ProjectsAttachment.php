<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProjectsAttachment
 * 
 * @property int $project_attachment_id
 * @property int $project_id
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
class ProjectsAttachment extends Model
{
	protected $table = 'projects_attachment';
	protected $primaryKey = 'project_attachment_id';

	protected $casts = [
		'project_id' => 'int',
		'upload_by' => 'int'
	];

	protected $fillable = [
		'project_id',
		'upload_by',
		'file_title',
		'file_description',
		'attachment_file',
		'legacy_created_at'
	];
}
