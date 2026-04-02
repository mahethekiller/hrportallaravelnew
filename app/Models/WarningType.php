<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WarningType
 * 
 * @property int $warning_type_id
 * @property int $company_id
 * @property string $type
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class WarningType extends Model
{
	protected $table = 'warning_type';
	protected $primaryKey = 'warning_type_id';
	public $incrementing = false;

	protected $casts = [
		'warning_type_id' => 'int',
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'type',
		'legacy_created_at'
	];
}
