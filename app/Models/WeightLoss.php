<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WeightLoss
 * 
 * @property int $id
 * @property string $title
 * @property string $filename
 * @property string $added_date
 * @property int $user_id
 * @property string $weight
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class WeightLoss extends Model
{
	protected $table = 'weight_loss';

	protected $casts = [
		'user_id' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'title',
		'filename',
		'added_date',
		'user_id',
		'weight',
		'show_status'
	];
}
