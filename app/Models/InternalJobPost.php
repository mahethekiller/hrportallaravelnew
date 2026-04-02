<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InternalJobPost
 * 
 * @property int $post_id
 * @property string $post_name
 * @property int $vacancies
 * @property int $company
 * @property string $description
 * @property int $status
 * @property int $show_status
 * @property string|null $legacy_created_at
 * @property int $added_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class InternalJobPost extends Model
{
	protected $table = 'internal_job_posts';
	protected $primaryKey = 'post_id';

	protected $casts = [
		'vacancies' => 'int',
		'company' => 'int',
		'status' => 'int',
		'show_status' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'post_name',
		'vacancies',
		'company',
		'description',
		'status',
		'show_status',
		'legacy_created_at',
		'added_by'
	];
}
