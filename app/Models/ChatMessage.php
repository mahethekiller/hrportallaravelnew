<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChatMessage
 * 
 * @property int $message_id
 * @property string $from_id
 * @property string $to_id
 * @property string $message_frm
 * @property int $is_read
 * @property string $message_content
 * @property string|null $message_date
 * @property bool $recd
 * @property string $message_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ChatMessage extends Model
{
	protected $table = 'chat_messages';
	protected $primaryKey = 'message_id';

	protected $casts = [
		'is_read' => 'int',
		'recd' => 'bool'
	];

	protected $fillable = [
		'from_id',
		'to_id',
		'message_frm',
		'is_read',
		'message_content',
		'message_date',
		'recd',
		'message_type'
	];
}
