<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethod
 * 
 * @property int $payment_method_id
 * @property int $company_id
 * @property string $method_name
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PaymentMethod extends Model
{
	protected $table = 'payment_method';
	protected $primaryKey = 'payment_method_id';

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'method_name',
		'legacy_created_at'
	];
}
