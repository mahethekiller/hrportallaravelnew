<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DisabledEmployee
 * 
 * @property int $id
 * @property string $employee_ids
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DisabledEmployee extends Model
{
	protected $table = 'disabled_employees';

	protected $fillable = [
		'employee_ids'
	];
}
