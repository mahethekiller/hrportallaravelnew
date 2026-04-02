<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LeaveType
 * 
 * @property int $leave_type_id
 * @property int $company_id
 * @property string $type_name
 * @property string $days_per_year
 * @property bool $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LeaveType extends Model
{
	protected $table = 'leave_type';
	protected $primaryKey = 'leave_type_id';

	protected $casts = [
		'company_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'company_id',
		'type_name',
		'days_per_year',
		'status',
		'legacy_created_at'
	];
}
