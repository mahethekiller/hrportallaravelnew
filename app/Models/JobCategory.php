<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JobCategory
 * 
 * @property int $category_id
 * @property string $category_name
 * @property string $category_url
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class JobCategory extends Model
{
	protected $table = 'job_categories';
	protected $primaryKey = 'category_id';

	protected $fillable = [
		'category_name',
		'category_url',
		'legacy_created_at'
	];
}
