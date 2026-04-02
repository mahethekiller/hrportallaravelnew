<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Award
 * 
 * @property int $award_id
 * @property int $company_id
 * @property int $employee_id
 * @property int $award_type_id
 * @property string $gift_item
 * @property string $cash_price
 * @property string $award_photo
 * @property string $award_month_year
 * @property string $award_information
 * @property string $description
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Award extends Model
{
	protected $table = 'awards';
	protected $primaryKey = 'award_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'award_type_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'award_type_id',
		'gift_item',
		'cash_price',
		'award_photo',
		'award_month_year',
		'award_information',
		'description',
		'legacy_created_at'
	];
}
