<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChildHoodImage
 * 
 * @property int $id
 * @property string $title
 * @property string $filename
 * @property string $added_date
 * @property int $user_id
 * @property string $name
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ChildHoodImage extends Model
{
	protected $table = 'child_hood_images';

	protected $casts = [
		'user_id' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'title',
		'filename',
		'added_date',
		'user_id',
		'name',
		'show_status'
	];
}
