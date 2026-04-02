<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FeedbackForm
 * 
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $show_status
 * @property string $added_date
 * @property string $added_by
 * @property string $show_until
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FeedbackForm extends Model
{
	protected $table = 'feedback_forms';

	protected $casts = [
		'show_status' => 'int'
	];

	protected $fillable = [
		'title',
		'description',
		'show_status',
		'added_date',
		'added_by',
		'show_until'
	];
}
