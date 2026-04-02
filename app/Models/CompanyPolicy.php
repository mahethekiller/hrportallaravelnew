<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CompanyPolicy
 * 
 * @property int $policy_id
 * @property int $company_id
 * @property string $title
 * @property string $description
 * @property int $added_by
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CompanyPolicy extends Model
{
	protected $table = 'company_policy';
	protected $primaryKey = 'policy_id';

	protected $casts = [
		'company_id' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'company_id',
		'title',
		'description',
		'added_by',
		'legacy_created_at'
	];
}
