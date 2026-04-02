<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FeedbackFormAnswer
 * 
 * @property int $id
 * @property int $user_id
 * @property int $form_id
 * @property int $question_id
 * @property string $answer
 * @property string $feedback
 * @property int $rating
 * @property string $added_date
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FeedbackFormAnswer extends Model
{
	protected $table = 'feedback_form_answers';

	protected $casts = [
		'user_id' => 'int',
		'form_id' => 'int',
		'question_id' => 'int',
		'rating' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'user_id',
		'form_id',
		'question_id',
		'answer',
		'feedback',
		'rating',
		'added_date',
		'show_status'
	];
}
