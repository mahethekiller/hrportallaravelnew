<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaxType
 * 
 * @property int $tax_id
 * @property string $name
 * @property string $rate
 * @property string $type
 * @property string $description
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TaxType extends Model
{
	protected $table = 'tax_types';
	protected $primaryKey = 'tax_id';
	public $incrementing = false;

	protected $casts = [
		'tax_id' => 'int'
	];

	protected $fillable = [
		'name',
		'rate',
		'type',
		'description',
		'legacy_created_at'
	];
}
