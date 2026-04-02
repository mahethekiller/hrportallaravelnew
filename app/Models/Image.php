<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 * 
 * @property int $id
 * @property string $title
 * @property int $album_id
 * @property string $filename
 * @property Carbon $added_date
 * @property int $isActive
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Image extends Model
{
	protected $table = 'images';

	protected $casts = [
		'album_id' => 'int',
		'added_date' => 'datetime',
		'isActive' => 'int'
	];

	protected $fillable = [
		'title',
		'album_id',
		'filename',
		'added_date',
		'isActive'
	];
}
