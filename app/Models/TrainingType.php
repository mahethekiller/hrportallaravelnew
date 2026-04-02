<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TrainingType
 * 
 * @property int $training_type_id
 * @property int $company_id
 * @property string $type
 * @property string|null $legacy_created_at
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TrainingType extends Model
{
	protected $table = 'training_types';
	protected $primaryKey = 'training_type_id';
	public $incrementing = false;

	protected $casts = [
		'training_type_id' => 'int',
		'company_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'company_id',
		'type',
		'legacy_created_at',
		'status'
	];
}
