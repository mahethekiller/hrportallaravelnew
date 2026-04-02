<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InterviewSalaryTemplate
 * 
 * @property int $salary_template_id
 * @property int $company_id
 * @property int $job_interview_id
 * @property string $salary_grades
 * @property string $basic_salary
 * @property string $overtime_rate
 * @property string $house_rent_allowance
 * @property string $meal_allowance
 * @property string $conveyance_allowance
 * @property string $health_ins_policy
 * @property string $books_periodical_allowance
 * @property string $provident_fund
 * @property string $special_allowance
 * @property string $blank
 * @property string $blank2
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
class InterviewSalaryTemplate extends Model
{
	protected $table = 'interview_salary_templates';
	protected $primaryKey = 'salary_template_id';

	protected $casts = [
		'company_id' => 'int',
		'job_interview_id' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'company_id',
		'job_interview_id',
		'salary_grades',
		'basic_salary',
		'overtime_rate',
		'house_rent_allowance',
		'meal_allowance',
		'conveyance_allowance',
		'health_ins_policy',
		'books_periodical_allowance',
		'provident_fund',
		'special_allowance',
		'blank',
		'blank2',
		'gross_salary',
		'total_allowance',
		'total_deduction',
		'net_salary',
		'added_by',
		'legacy_created_at'
	];
}
