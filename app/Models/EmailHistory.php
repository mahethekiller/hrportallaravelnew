<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailHistory
 * 
 * @property int $id
 * @property string $subject
 * @property string $message
 * @property string $from_email
 * @property string $to_emails
 * @property string $sent_date
 * @property string $mail_type
 * @property int $mail_type_id
 * @property int $user_id
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmailHistory extends Model
{
	protected $table = 'email_history';

	protected $casts = [
		'mail_type_id' => 'int',
		'user_id' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'subject',
		'message',
		'from_email',
		'to_emails',
		'sent_date',
		'mail_type',
		'mail_type_id',
		'user_id',
		'show_status'
	];
}
