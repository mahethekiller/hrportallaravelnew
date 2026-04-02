<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IncomeCategory
 * 
 * @property int $category_id
 * @property string $name
 * @property bool $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class IncomeCategory extends Model
{
	protected $table = 'income_categories';
	protected $primaryKey = 'category_id';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'name',
		'status',
		'legacy_created_at'
	];
}
