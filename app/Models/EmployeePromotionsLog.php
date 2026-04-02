<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeePromotionsLog
 * 
 * @property int $id
 * @property int $promotion_id
 * @property int $company_id
 * @property int $employee_id
 * @property string $title
 * @property string $promotion_date
 * @property string $description
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeePromotionsLog extends Model
{
	protected $table = 'employee_promotions_log';

	protected $casts = [
		'promotion_id' => 'int',
		'company_id' => 'int',
		'employee_id' => 'int',
		'added_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'promotion_id',
		'company_id',
		'employee_id',
		'title',
		'promotion_date',
		'description',
		'added_by',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
