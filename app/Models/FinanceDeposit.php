<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinanceDeposit
 * 
 * @property int $deposit_id
 * @property int $account_type_id
 * @property string $amount
 * @property string $deposit_date
 * @property int $category_id
 * @property int $payer_id
 * @property int $payment_method
 * @property string $deposit_reference
 * @property string $deposit_file
 * @property string $description
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FinanceDeposit extends Model
{
	protected $table = 'finance_deposit';
	protected $primaryKey = 'deposit_id';

	protected $casts = [
		'account_type_id' => 'int',
		'category_id' => 'int',
		'payer_id' => 'int',
		'payment_method' => 'int'
	];

	protected $fillable = [
		'account_type_id',
		'amount',
		'deposit_date',
		'category_id',
		'payer_id',
		'payment_method',
		'deposit_reference',
		'deposit_file',
		'description',
		'legacy_created_at'
	];
}
