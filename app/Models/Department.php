<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $department_id
 * @property string $department_name
 * @property int $company_id
 * @property int $location_id
 * @property int $employee_id
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Department extends Model
{
	protected $table = 'departments';
	protected $primaryKey = 'department_id';

	protected $casts = [
		'company_id' => 'int',
		'location_id' => 'int',
		'employee_id' => 'int',
		'added_by' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'department_name',
		'company_id',
		'location_id',
		'employee_id',
		'added_by',
		'legacy_created_at',
		'status'
	];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}
