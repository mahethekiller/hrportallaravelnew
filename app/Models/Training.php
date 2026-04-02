<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Training
 * 
 * @property int $training_id
 * @property int $company_id
 * @property string $employee_id
 * @property int $training_type_id
 * @property int $trainer_id
 * @property string $start_date
 * @property string $finish_date
 * @property string $training_cost
 * @property int $training_status
 * @property string $description
 * @property string $performance
 * @property string $remarks
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Training extends Model
{
	protected $table = 'training';
	protected $primaryKey = 'training_id';
	public $incrementing = false;

	protected $casts = [
		'training_id' => 'int',
		'company_id' => 'int',
		'training_type_id' => 'int',
		'trainer_id' => 'int',
		'training_status' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'training_type_id',
		'trainer_id',
		'start_date',
		'finish_date',
		'training_cost',
		'training_status',
		'description',
		'performance',
		'remarks',
		'legacy_created_at'
	];
}
