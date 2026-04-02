<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRole
 * 
 * @property int $role_id
 * @property int $company_id
 * @property string $role_name
 * @property string $role_access
 * @property string $role_resources
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class UserRole extends Model
{
	protected $table = 'user_roles';
	protected $primaryKey = 'role_id';

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'role_name',
		'role_access',
		'role_resources',
		'legacy_created_at'
	];
}
