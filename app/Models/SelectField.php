<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SelectField
 * 
 * @property int $id
 * @property string $select_name
 * @property string $title
 * @property string $value
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SelectField extends Model
{
	protected $table = 'select_fields';

	protected $casts = [
		'show_status' => 'int'
	];

	protected $fillable = [
		'select_name',
		'title',
		'value',
		'show_status'
	];
}
