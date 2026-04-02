<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdvanceSalary
 * 
 * @property int $advance_salary_id
 * @property int $company_id
 * @property int $employee_id
 * @property string $month_year
 * @property string $advance_amount
 * @property string $one_time_deduct
 * @property string $monthly_installment
 * @property string $total_paid
 * @property string $reason
 * @property int|null $status
 * @property int|null $is_deducted_from_salary
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AdvanceSalary extends Model
{
	protected $table = 'advance_salaries';
	protected $primaryKey = 'advance_salary_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'status' => 'int',
		'is_deducted_from_salary' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'month_year',
		'advance_amount',
		'one_time_deduct',
		'monthly_installment',
		'total_paid',
		'reason',
		'status',
		'is_deducted_from_salary',
		'legacy_created_at'
	];
}
