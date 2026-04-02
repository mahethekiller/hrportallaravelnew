<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Job
 * 
 * @property int $job_id
 * @property int $company_id
 * @property string $job_code
 * @property string $job_title
 * @property int $designation_id
 * @property int $job_type
 * @property int $is_featured
 * @property int $job_vacancy
 * @property string $gender
 * @property string $minimum_experience
 * @property string $maximum_experience
 * @property string|null $start_date
 * @property string $date_of_closing
 * @property int $department
 * @property string $priority
 * @property int $hiring_manager
 * @property string $job_location
 * @property string $short_description
 * @property string $long_description
 * @property int $status
 * @property string $show_on_website
 * @property string|null $legacy_created_at
 * @property string $added_by
 * @property string|null $updated_date
 * @property int|null $updated_by
 * @property int|null $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Job extends Model
{
	protected $table = 'jobs';
	protected $primaryKey = 'job_id';

	protected $casts = [
		'company_id' => 'int',
		'designation_id' => 'int',
		'job_type' => 'int',
		'is_featured' => 'int',
		'job_vacancy' => 'int',
		'department' => 'int',
		'hiring_manager' => 'int',
		'status' => 'int',
		'updated_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'company_id',
		'job_code',
		'job_title',
		'designation_id',
		'job_type',
		'is_featured',
		'job_vacancy',
		'gender',
		'minimum_experience',
		'maximum_experience',
		'start_date',
		'date_of_closing',
		'department',
		'priority',
		'hiring_manager',
		'job_location',
		'short_description',
		'long_description',
		'status',
		'show_on_website',
		'legacy_created_at',
		'added_by',
		'updated_date',
		'updated_by',
		'show_status'
	];
}
