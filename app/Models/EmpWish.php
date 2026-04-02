<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmpWish
 * 
 * @property int $id
 * @property int $recieving_emp
 * @property int $wished_by
 * @property string $message
 * @property Carbon $date
 * @property string $wish_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmpWish extends Model
{
	protected $table = 'emp_wishes';

	protected $casts = [
		'recieving_emp' => 'int',
		'wished_by' => 'int',
		'date' => 'datetime'
	];

	protected $fillable = [
		'recieving_emp',
		'wished_by',
		'message',
		'date',
		'wish_type'
	];
}
