<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeComplaintsLog
 * 
 * @property int $id
 * @property int $complaint_id
 * @property int $company_id
 * @property int $complaint_from
 * @property string $title
 * @property string $complaint_date
 * @property string $complaint_against
 * @property string $description
 * @property int $status
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeComplaintsLog extends Model
{
	protected $table = 'employee_complaints_log';

	protected $casts = [
		'complaint_id' => 'int',
		'company_id' => 'int',
		'complaint_from' => 'int',
		'status' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'complaint_id',
		'company_id',
		'complaint_from',
		'title',
		'complaint_date',
		'complaint_against',
		'description',
		'status',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
