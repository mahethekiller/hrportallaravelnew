<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeBankaccountLog
 * 
 * @property int $id
 * @property int $bankaccount_id
 * @property int $employee_id
 * @property int $is_primary
 * @property string $account_title
 * @property string $account_number
 * @property string $bank_name
 * @property string $bank_code
 * @property string $bank_branch
 * @property string|null $legacy_created_at
 * @property int $updated_by
 * @property string $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeBankaccountLog extends Model
{
	protected $table = 'employee_bankaccount_log';

	protected $casts = [
		'bankaccount_id' => 'int',
		'employee_id' => 'int',
		'is_primary' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'bankaccount_id',
		'employee_id',
		'is_primary',
		'account_title',
		'account_number',
		'bank_name',
		'bank_code',
		'bank_branch',
		'legacy_created_at',
		'updated_by',
		'updated_date'
	];
}
