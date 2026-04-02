<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Designation
 * 
 * @property int $designation_id
 * @property int $top_designation_id
 * @property int $department_id
 * @property int $company_id
 * @property string $designation_name
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Designation extends Model
{
	protected $table = 'designations';
	protected $primaryKey = 'designation_id';

	protected $casts = [
		'top_designation_id' => 'int',
		'department_id' => 'int',
		'company_id' => 'int',
		'added_by' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'top_designation_id',
		'department_id',
		'company_id',
		'designation_name',
		'added_by',
		'legacy_created_at',
		'status'
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
