<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmpHealthIn
 * 
 * @property int $id
 * @property int $user_id
 * @property string $spouse_name
 * @property string $spouse_gender
 * @property string $spouse_dob
 * @property string $child1_name
 * @property string $child1_gender
 * @property string $child1_dob
 * @property string $child2_name
 * @property string $child2_dob
 * @property string $child2_gender
 * @property string $parent1_name
 * @property string $parent1_gender
 * @property string $parent1_dob
 * @property string $parent2_name
 * @property string $parent2_gender
 * @property string $parent2_dob
 * @property string $parent1_relation
 * @property string $parent2_relation
 * @property string $added_date
 * @property string $remarks
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmpHealthIn extends Model
{
	protected $table = 'emp_health_ins';

	protected $casts = [
		'user_id' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'user_id',
		'spouse_name',
		'spouse_gender',
		'spouse_dob',
		'child1_name',
		'child1_gender',
		'child1_dob',
		'child2_name',
		'child2_dob',
		'child2_gender',
		'parent1_name',
		'parent1_gender',
		'parent1_dob',
		'parent2_name',
		'parent2_gender',
		'parent2_dob',
		'parent1_relation',
		'parent2_relation',
		'added_date',
		'remarks',
		'show_status'
	];
}
