<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeBankaccount
 * 
 * @property int $bankaccount_id
 * @property int $employee_id
 * @property int $is_primary
 * @property string $account_title
 * @property string $account_number
 * @property string $bank_name
 * @property string $bank_code
 * @property string $bank_branch
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeBankaccount extends Model
{
	protected $table = 'employee_bankaccount';
	protected $primaryKey = 'bankaccount_id';

	protected $casts = [
		'employee_id' => 'int',
		'is_primary' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'is_primary',
		'account_title',
		'account_number',
		'bank_name',
		'bank_code',
		'bank_branch',
		'legacy_created_at'
	];
}
