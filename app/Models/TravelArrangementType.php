<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TravelArrangementType
 * 
 * @property int $arrangement_type_id
 * @property int $company_id
 * @property string $type
 * @property bool $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TravelArrangementType extends Model
{
	protected $table = 'travel_arrangement_type';
	protected $primaryKey = 'arrangement_type_id';
	public $incrementing = false;

	protected $casts = [
		'arrangement_type_id' => 'int',
		'company_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'company_id',
		'type',
		'status',
		'legacy_created_at'
	];
}
