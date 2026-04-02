<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 * 
 * @property int $language_id
 * @property string $language_name
 * @property string $language_code
 * @property string $language_flag
 * @property int $is_active
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Language extends Model
{
	protected $table = 'languages';
	protected $primaryKey = 'language_id';

	protected $casts = [
		'is_active' => 'int'
	];

	protected $fillable = [
		'language_name',
		'language_code',
		'language_flag',
		'is_active',
		'legacy_created_at'
	];
}
