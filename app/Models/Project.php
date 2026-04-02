<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * 
 * @property int $project_id
 * @property string $title
 * @property int $client_id
 * @property string $start_date
 * @property string $end_date
 * @property int $company_id
 * @property string $assigned_to
 * @property string $priority
 * @property string $summary
 * @property string $description
 * @property int $added_by
 * @property string $project_progress
 * @property string $project_note
 * @property int $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Project extends Model
{
	protected $table = 'projects';
	protected $primaryKey = 'project_id';

	protected $casts = [
		'client_id' => 'int',
		'company_id' => 'int',
		'added_by' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'title',
		'client_id',
		'start_date',
		'end_date',
		'company_id',
		'assigned_to',
		'priority',
		'summary',
		'description',
		'added_by',
		'project_progress',
		'project_note',
		'status',
		'legacy_created_at'
	];
}
