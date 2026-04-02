<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SupportTicketFile
 * 
 * @property int $ticket_file_id
 * @property int $ticket_id
 * @property int $employee_id
 * @property string $ticket_files
 * @property string $file_size
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SupportTicketFile extends Model
{
	protected $table = 'support_ticket_files';
	protected $primaryKey = 'ticket_file_id';

	protected $casts = [
		'ticket_id' => 'int',
		'employee_id' => 'int'
	];

	protected $fillable = [
		'ticket_id',
		'employee_id',
		'ticket_files',
		'file_size',
		'legacy_created_at'
	];
}
