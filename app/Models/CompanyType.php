<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CompanyType
 * 
 * @property int $type_id
 * @property string $name
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CompanyType extends Model
{
	protected $table = 'company_type';
	protected $primaryKey = 'type_id';

	protected $fillable = [
		'name',
		'legacy_created_at'
	];
}
