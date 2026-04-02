<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AssetsCategory
 * 
 * @property int $assets_category_id
 * @property int $company_id
 * @property string $category_name
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AssetsCategory extends Model
{
	protected $table = 'assets_categories';
	protected $primaryKey = 'assets_category_id';

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'category_name',
		'legacy_created_at'
	];
}
