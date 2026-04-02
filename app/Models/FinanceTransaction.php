<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinanceTransaction
 * 
 * @property int $transaction_id
 * @property int $account_type_id
 * @property int $deposit_id
 * @property int $expense_id
 * @property int $transfer_id
 * @property string $transaction_type
 * @property string $total_amount
 * @property string $transaction_debit
 * @property string $transaction_credit
 * @property string $transaction_date
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FinanceTransaction extends Model
{
	protected $table = 'finance_transactions';
	protected $primaryKey = 'transaction_id';

	protected $casts = [
		'account_type_id' => 'int',
		'deposit_id' => 'int',
		'expense_id' => 'int',
		'transfer_id' => 'int'
	];

	protected $fillable = [
		'account_type_id',
		'deposit_id',
		'expense_id',
		'transfer_id',
		'transaction_type',
		'total_amount',
		'transaction_debit',
		'transaction_credit',
		'transaction_date',
		'legacy_created_at'
	];
}
