<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Announcement
 * 
 * @property int $announcement_id
 * @property string $title
 * @property string $announcement_type
 * @property string $acceptance_message
 * @property string $start_date
 * @property string $end_date
 * @property int $company_id
 * @property int $department_id
 * @property int $published_by
 * @property string $summary
 * @property string $description
 * @property string $image
 * @property bool $is_active
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Announcement extends Model
{
	protected $table = 'announcements';
	protected $primaryKey = 'announcement_id';

	protected $casts = [
		'company_id' => 'int',
		'department_id' => 'int',
		'published_by' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'title',
		'announcement_type',
		'acceptance_message',
		'start_date',
		'end_date',
		'company_id',
		'department_id',
		'published_by',
		'summary',
		'description',
		'image',
		'is_active',
		'legacy_created_at'
	];
}
