<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FileManager
 * 
 * @property int $file_id
 * @property int $user_id
 * @property int $department_id
 * @property string $file_name
 * @property string $file_size
 * @property string $file_extension
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FileManager extends Model
{
	protected $table = 'file_manager';
	protected $primaryKey = 'file_id';

	protected $casts = [
		'user_id' => 'int',
		'department_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'department_id',
		'file_name',
		'file_size',
		'file_extension',
		'legacy_created_at'
	];
}
