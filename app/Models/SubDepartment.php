<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubDepartment
 * 
 * @property int $sub_department_id
 * @property int $company_id
 * @property int $department_id
 * @property string $department_name
 * @property int $show_status
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SubDepartment extends Model
{
	protected $table = 'sub_departments';
	protected $primaryKey = 'sub_department_id';

	protected $casts = [
		'company_id' => 'int',
		'department_id' => 'int',
		'show_status' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'company_id',
		'department_id',
		'department_name',
		'show_status',
		'added_by',
		'legacy_created_at'
	];

	public function company()
	{
		return $this->belongsTo(Company::class, 'company_id', 'company_id');
	}

	public function department()
	{
		return $this->belongsTo(Department::class, 'department_id', 'department_id');
	}
}
