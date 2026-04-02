<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * 
 * @property int $country_id
 * @property string $country_code
 * @property string $country_name
 * @property string $country_flag
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Country extends Model
{
	protected $table = 'countries';
	protected $primaryKey = 'country_id';

	protected $fillable = [
		'country_code',
		'country_name',
		'country_flag'
	];
}
