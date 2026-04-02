<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinanceBankcash
 * 
 * @property int $bankcash_id
 * @property string $account_name
 * @property string $account_balance
 * @property string $account_number
 * @property string $branch_code
 * @property string $bank_branch
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FinanceBankcash extends Model
{
	protected $table = 'finance_bankcash';
	protected $primaryKey = 'bankcash_id';

	protected $fillable = [
		'account_name',
		'account_balance',
		'account_number',
		'branch_code',
		'bank_branch',
		'legacy_created_at'
	];
}
