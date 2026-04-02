<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Album
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $cover_url
 * @property string|null $google_drive_link
 * @property Carbon $added_date
 * @property int $added_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Album extends Model
{
	protected $table = 'albums';

	protected $casts = [
		'added_date' => 'datetime',
		'added_by' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'cover_url',
		'google_drive_link',
		'added_date',
		'added_by'
	];
}
