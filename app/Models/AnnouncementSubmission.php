<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AnnouncementSubmission
 * 
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $employee_id
 * @property int $announcement_id
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AnnouncementSubmission extends Model
{
	protected $table = 'announcement_submissions';

	protected $casts = [
		'user_id' => 'int',
		'announcement_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'name',
		'employee_id',
		'announcement_id',
		'legacy_created_at'
	];
}
