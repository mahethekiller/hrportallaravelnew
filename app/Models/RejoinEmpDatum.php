<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RejoinEmpDatum
 * 
 * @property int $id
 * @property int $employee_id
 * @property string $old_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class RejoinEmpDatum extends Model
{
	protected $table = 'rejoin_emp_data';

	protected $casts = [
		'employee_id' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'old_data'
	];
}
