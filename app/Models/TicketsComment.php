<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TicketsComment
 * 
 * @property int $comment_id
 * @property int $ticket_id
 * @property int $user_id
 * @property string $ticket_comments
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TicketsComment extends Model
{
	protected $table = 'tickets_comments';
	protected $primaryKey = 'comment_id';

	protected $casts = [
		'ticket_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'ticket_id',
		'user_id',
		'ticket_comments',
		'legacy_created_at'
	];
}
