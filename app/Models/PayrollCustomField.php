<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PayrollCustomField
 * 
 * @property int $payroll_custom_id
 * @property string $allow_custom_1
 * @property int $is_active_allow_1
 * @property string $allow_custom_2
 * @property int $is_active_allow_2
 * @property string $allow_custom_3
 * @property int $is_active_allow_3
 * @property string $allow_custom_4
 * @property int $is_active_allow_4
 * @property string $allow_custom_5
 * @property int $is_active_allow_5
 * @property string $deduct_custom_1
 * @property int $is_active_deduct_1
 * @property string $deduct_custom_2
 * @property int $is_active_deduct_2
 * @property string $deduct_custom_3
 * @property int $is_active_deduct_3
 * @property string $deduct_custom_4
 * @property int $is_active_deduct_4
 * @property string $deduct_custom_5
 * @property int $is_active_deduct_5
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PayrollCustomField extends Model
{
	protected $table = 'payroll_custom_fields';
	protected $primaryKey = 'payroll_custom_id';

	protected $casts = [
		'is_active_allow_1' => 'int',
		'is_active_allow_2' => 'int',
		'is_active_allow_3' => 'int',
		'is_active_allow_4' => 'int',
		'is_active_allow_5' => 'int',
		'is_active_deduct_1' => 'int',
		'is_active_deduct_2' => 'int',
		'is_active_deduct_3' => 'int',
		'is_active_deduct_4' => 'int',
		'is_active_deduct_5' => 'int'
	];

	protected $fillable = [
		'allow_custom_1',
		'is_active_allow_1',
		'allow_custom_2',
		'is_active_allow_2',
		'allow_custom_3',
		'is_active_allow_3',
		'allow_custom_4',
		'is_active_allow_4',
		'allow_custom_5',
		'is_active_allow_5',
		'deduct_custom_1',
		'is_active_deduct_1',
		'deduct_custom_2',
		'is_active_deduct_2',
		'deduct_custom_3',
		'is_active_deduct_3',
		'deduct_custom_4',
		'is_active_deduct_4',
		'deduct_custom_5',
		'is_active_deduct_5'
	];
}
