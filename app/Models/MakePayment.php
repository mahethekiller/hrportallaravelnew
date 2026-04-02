<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MakePayment
 * 
 * @property int $make_payment_id
 * @property int $employee_id
 * @property int $department_id
 * @property int $company_id
 * @property int $location_id
 * @property int $designation_id
 * @property string $payment_date
 * @property string $basic_salary
 * @property string $payment_amount
 * @property string $gross_salary
 * @property string $total_allowances
 * @property string $total_deductions
 * @property string $net_salary
 * @property string $house_rent_allowance
 * @property string $medical_allowance
 * @property string $travelling_allowance
 * @property string $dearness_allowance
 * @property string $provident_fund
 * @property string $tax_deduction
 * @property string $security_deposit
 * @property string $overtime_rate
 * @property int $is_advance_salary_deduct
 * @property string $advance_salary_amount
 * @property bool $is_payment
 * @property int $payment_method
 * @property string $hourly_rate
 * @property string $total_hours_work
 * @property string $comments
 * @property bool $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MakePayment extends Model
{
	protected $table = 'make_payment';
	protected $primaryKey = 'make_payment_id';

	protected $casts = [
		'employee_id' => 'int',
		'department_id' => 'int',
		'company_id' => 'int',
		'location_id' => 'int',
		'designation_id' => 'int',
		'is_advance_salary_deduct' => 'int',
		'is_payment' => 'bool',
		'payment_method' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'employee_id',
		'department_id',
		'company_id',
		'location_id',
		'designation_id',
		'payment_date',
		'basic_salary',
		'payment_amount',
		'gross_salary',
		'total_allowances',
		'total_deductions',
		'net_salary',
		'house_rent_allowance',
		'medical_allowance',
		'travelling_allowance',
		'dearness_allowance',
		'provident_fund',
		'tax_deduction',
		'security_deposit',
		'overtime_rate',
		'is_advance_salary_deduct',
		'advance_salary_amount',
		'is_payment',
		'payment_method',
		'hourly_rate',
		'total_hours_work',
		'comments',
		'status',
		'legacy_created_at'
	];
}
