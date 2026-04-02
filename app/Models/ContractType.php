<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ContractType
 * 
 * @property int $contract_type_id
 * @property int $company_id
 * @property string $name
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ContractType extends Model
{
	protected $table = 'contract_type';
	protected $primaryKey = 'contract_type_id';

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'name',
		'legacy_created_at'
	];
}
