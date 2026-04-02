<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JobType
 * 
 * @property int $job_type_id
 * @property int $company_id
 * @property string $type
 * @property string $type_url
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class JobType extends Model
{
	protected $table = 'job_type';
	protected $primaryKey = 'job_type_id';

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'type',
		'type_url',
		'legacy_created_at'
	];
}
