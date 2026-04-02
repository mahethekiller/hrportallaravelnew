<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinanceTransfer
 * 
 * @property int $transfer_id
 * @property int $from_account_id
 * @property int $to_account_id
 * @property string $transfer_date
 * @property string $transfer_amount
 * @property string $payment_method
 * @property string $transfer_reference
 * @property string $description
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FinanceTransfer extends Model
{
	protected $table = 'finance_transfer';
	protected $primaryKey = 'transfer_id';

	protected $casts = [
		'from_account_id' => 'int',
		'to_account_id' => 'int'
	];

	protected $fillable = [
		'from_account_id',
		'to_account_id',
		'transfer_date',
		'transfer_amount',
		'payment_method',
		'transfer_reference',
		'description',
		'legacy_created_at'
	];
}
