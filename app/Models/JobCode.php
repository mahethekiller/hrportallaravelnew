<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JobCode
 * 
 * @property int $job_code_id
 * @property int $company_id
 * @property string $job_code
 * @property string $position
 * @property int $added_by
 * @property string $added_date
 * @property int $updated_by
 * @property string $updated_date
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class JobCode extends Model
{
	protected $table = 'job_codes';
	protected $primaryKey = 'job_code_id';

	protected $casts = [
		'company_id' => 'int',
		'added_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'company_id',
		'job_code',
		'position',
		'added_by',
		'added_date',
		'updated_by',
		'updated_date',
		'status'
	];
}
