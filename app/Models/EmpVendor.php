<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmpVendor
 * 
 * @property int $vendor_id
 * @property string $vendor_name
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmpVendor extends Model
{
	protected $table = 'emp_vendors';
	protected $primaryKey = 'vendor_id';

	protected $casts = [
		'show_status' => 'int'
	];

	protected $fillable = [
		'vendor_name',
		'show_status'
	];
}
