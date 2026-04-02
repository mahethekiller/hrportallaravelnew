<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinancePayer
 * 
 * @property int $payer_id
 * @property string $payer_name
 * @property string $contact_number
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FinancePayer extends Model
{
	protected $table = 'finance_payers';
	protected $primaryKey = 'payer_id';

	protected $fillable = [
		'payer_name',
		'contact_number',
		'legacy_created_at'
	];
}
