<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 * 
 * @property int $currency_id
 * @property int $company_id
 * @property string $name
 * @property string $code
 * @property string $symbol
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Currency extends Model
{
	protected $table = 'currencies';
	protected $primaryKey = 'currency_id';

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'name',
		'code',
		'symbol'
	];
}
