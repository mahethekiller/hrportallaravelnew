<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AwardType
 * 
 * @property int $award_type_id
 * @property int $company_id
 * @property string $award_type
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AwardType extends Model
{
	protected $table = 'award_type';
	protected $primaryKey = 'award_type_id';

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'award_type',
		'legacy_created_at'
	];
}
