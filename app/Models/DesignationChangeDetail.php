<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DesignationChangeDetail
 * 
 * @property int $id
 * @property int $employee_id
 * @property string $old_designation
 * @property string $new_designation
 * @property string $update_date
 * @property int $added_by
 * @property string $added_date
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DesignationChangeDetail extends Model
{
	protected $table = 'designation_change_details';

	protected $casts = [
		'employee_id' => 'int',
		'added_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'old_designation',
		'new_designation',
		'update_date',
		'added_by',
		'added_date',
		'show_status'
	];
}
