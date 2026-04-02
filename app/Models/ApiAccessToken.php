<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiAccessToken
 * 
 * @property int $id
 * @property string|null $username
 * @property string $accessToken
 * @property int $status
 * @property string $added_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ApiAccessToken extends Model
{
	protected $table = 'api_access_tokens';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'username',
		'accessToken',
		'status',
		'added_date'
	];
}
