<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FileManagerSetting
 * 
 * @property int $setting_id
 * @property string $allowed_extensions
 * @property string $maximum_file_size
 * @property string $is_enable_all_files
 * @property string $updated_at
 * @property Carbon|null $created_at
 *
 * @package App\Models
 */
class FileManagerSetting extends Model
{
	protected $table = 'file_manager_settings';
	protected $primaryKey = 'setting_id';

	protected $fillable = [
		'allowed_extensions',
		'maximum_file_size',
		'is_enable_all_files'
	];
}
