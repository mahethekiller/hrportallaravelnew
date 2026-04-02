<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmpDevice
 * 
 * @property int $id
 * @property int $user_id
 * @property string $device
 * @property string $service_tag
 * @property string $added_date
 * @property int $added_by
 * @property int $show_status
 * @property string $description
 * @property string|null $phone_no
 * @property string $return_status
 * @property string $return_date
 * @property int|null $last_updated_by
 * @property string|null $last_updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmpDevice extends Model
{
	protected $table = 'emp_devices';

	protected $casts = [
		'user_id' => 'int',
		'added_by' => 'int',
		'show_status' => 'int',
		'last_updated_by' => 'int'
	];

	protected $fillable = [
		'user_id',
		'device',
		'service_tag',
		'added_date',
		'added_by',
		'show_status',
		'description',
		'phone_no',
		'return_status',
		'return_date',
		'last_updated_by',
		'last_updated_date'
	];
}
