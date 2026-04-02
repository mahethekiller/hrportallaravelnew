<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeComplaint
 * 
 * @property int $complaint_id
 * @property int $company_id
 * @property int $complaint_from
 * @property string $title
 * @property string $complaint_date
 * @property string $complaint_against
 * @property string $description
 * @property int $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeComplaint extends Model
{
	protected $table = 'employee_complaints';
	protected $primaryKey = 'complaint_id';

	protected $casts = [
		'company_id' => 'int',
		'complaint_from' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'company_id',
		'complaint_from',
		'title',
		'complaint_date',
		'complaint_against',
		'description',
		'status',
		'legacy_created_at'
	];
}
