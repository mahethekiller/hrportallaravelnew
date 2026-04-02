<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalaryTemplate
 * 
 * @property int $salary_template_id
 * @property int $company_id
 * @property int $employee_id
 * @property string $salary_grades
 * @property string $basic_salary
 * @property string $overtime_rate
 * @property string $house_rent_allowance
 * @property string $medical_allowance
 * @property string $travelling_allowance
 * @property string $dearness_allowance
 * @property string $security_deposit
 * @property string $provident_fund
 * @property string $tax_deduction
 * @property string $gross_salary
 * @property string $total_allowance
 * @property string $total_deduction
 * @property string $net_salary
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SalaryTemplate extends Model
{
	protected $table = 'salary_templates';
	protected $primaryKey = 'salary_template_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'salary_grades',
		'basic_salary',
		'overtime_rate',
		'house_rent_allowance',
		'medical_allowance',
		'travelling_allowance',
		'dearness_allowance',
		'security_deposit',
		'provident_fund',
		'tax_deduction',
		'gross_salary',
		'total_allowance',
		'total_deduction',
		'net_salary',
		'added_by',
		'legacy_created_at'
	];
}
