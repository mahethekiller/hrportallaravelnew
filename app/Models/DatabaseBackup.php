<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DatabaseBackup
 * 
 * @property int $backup_id
 * @property string $backup_file
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DatabaseBackup extends Model
{
	protected $table = 'database_backup';
	protected $primaryKey = 'backup_id';

	protected $fillable = [
		'backup_file',
		'legacy_created_at'
	];
}
