<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TicketsAttachment
 * 
 * @property int $ticket_attachment_id
 * @property int $ticket_id
 * @property int $upload_by
 * @property string $file_title
 * @property string $file_description
 * @property string $attachment_file
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TicketsAttachment extends Model
{
	protected $table = 'tickets_attachment';
	protected $primaryKey = 'ticket_attachment_id';
	public $incrementing = false;

	protected $casts = [
		'ticket_attachment_id' => 'int',
		'ticket_id' => 'int',
		'upload_by' => 'int'
	];

	protected $fillable = [
		'ticket_id',
		'upload_by',
		'file_title',
		'file_description',
		'attachment_file',
		'legacy_created_at'
	];
}
