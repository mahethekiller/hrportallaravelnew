<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinanceExpense
 * 
 * @property int $expense_id
 * @property int $account_type_id
 * @property string $amount
 * @property string $expense_date
 * @property int $category_id
 * @property int $payee_id
 * @property int $payment_method
 * @property string $expense_reference
 * @property string $expense_file
 * @property string $description
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FinanceExpense extends Model
{
	protected $table = 'finance_expense';
	protected $primaryKey = 'expense_id';

	protected $casts = [
		'account_type_id' => 'int',
		'category_id' => 'int',
		'payee_id' => 'int',
		'payment_method' => 'int'
	];

	protected $fillable = [
		'account_type_id',
		'amount',
		'expense_date',
		'category_id',
		'payee_id',
		'payment_method',
		'expense_reference',
		'expense_file',
		'description',
		'legacy_created_at'
	];
}
