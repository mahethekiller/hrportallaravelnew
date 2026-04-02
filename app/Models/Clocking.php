<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Clocking
 * 
 * @property int $id
 * @property int $userid
 * @property string $clock_in
 * @property string $clock_out
 * @property string $description
 * @property string|null $legacy_created_at
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Clocking extends Model
{
	protected $table = 'clocking';

	protected $casts = [
		'userid' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'userid',
		'clock_in',
		'clock_out',
		'description',
		'legacy_created_at',
		'show_status'
	];
}
