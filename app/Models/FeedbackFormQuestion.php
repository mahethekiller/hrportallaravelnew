<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FeedbackFormQuestion
 * 
 * @property int $id
 * @property int $form_id
 * @property string $question
 * @property string $type
 * @property string $option1
 * @property string $option2
 * @property string $option3
 * @property string $option4
 * @property string $option5
 * @property string $added_date
 * @property int $added_by
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FeedbackFormQuestion extends Model
{
	protected $table = 'feedback_form_questions';

	protected $casts = [
		'form_id' => 'int',
		'added_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'form_id',
		'question',
		'type',
		'option1',
		'option2',
		'option3',
		'option4',
		'option5',
		'added_date',
		'added_by',
		'show_status'
	];
}
