<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeePromotion
 * 
 * @property int $promotion_id
 * @property int $company_id
 * @property int $employee_id
 * @property string $title
 * @property string $promotion_date
 * @property string $description
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeePromotion extends Model
{
	protected $table = 'employee_promotions';
	protected $primaryKey = 'promotion_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'title',
		'promotion_date',
		'description',
		'added_by',
		'legacy_created_at'
	];
}
