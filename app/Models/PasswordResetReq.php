<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordResetReq
 * 
 * @property int $id
 * @property string $employee_id
 * @property string $last_pass
 * @property string $req_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PasswordResetReq extends Model
{
	protected $table = 'password_reset_req';

	protected $fillable = [
		'employee_id',
		'last_pass',
		'req_date'
	];
}
