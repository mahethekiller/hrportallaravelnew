<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OfficeShift
 * 
 * @property int $office_shift_id
 * @property int $company_id
 * @property string $shift_name
 * @property int $default_shift
 * @property string $monday_in_time
 * @property string $monday_out_time
 * @property string $tuesday_in_time
 * @property string $tuesday_out_time
 * @property string $wednesday_in_time
 * @property string $wednesday_out_time
 * @property string $thursday_in_time
 * @property string $thursday_out_time
 * @property string $friday_in_time
 * @property string $friday_out_time
 * @property string $saturday_in_time
 * @property string $saturday_out_time
 * @property string $sunday_in_time
 * @property string $sunday_out_time
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OfficeShift extends Model
{
	protected $table = 'office_shift';
	protected $primaryKey = 'office_shift_id';

	protected $casts = [
		'company_id' => 'int',
		'default_shift' => 'int'
	];

	protected $fillable = [
		'company_id',
		'shift_name',
		'default_shift',
		'monday_in_time',
		'monday_out_time',
		'tuesday_in_time',
		'tuesday_out_time',
		'wednesday_in_time',
		'wednesday_out_time',
		'thursday_in_time',
		'thursday_out_time',
		'friday_in_time',
		'friday_out_time',
		'saturday_in_time',
		'saturday_out_time',
		'sunday_in_time',
		'sunday_out_time',
		'legacy_created_at'
	];
}
