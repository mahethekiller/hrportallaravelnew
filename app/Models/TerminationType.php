<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TerminationType
 * 
 * @property int $termination_type_id
 * @property int $company_id
 * @property string $type
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TerminationType extends Model
{
	protected $table = 'termination_type';
	protected $primaryKey = 'termination_type_id';
	public $incrementing = false;

	protected $casts = [
		'termination_type_id' => 'int',
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'type',
		'legacy_created_at'
	];
}
