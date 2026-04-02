<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinancePayee
 * 
 * @property int $payee_id
 * @property string $payee_name
 * @property string $contact_number
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FinancePayee extends Model
{
	protected $table = 'finance_payees';
	protected $primaryKey = 'payee_id';

	protected $fillable = [
		'payee_name',
		'contact_number',
		'legacy_created_at'
	];
}
