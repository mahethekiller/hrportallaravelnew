<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SupportTicket
 * 
 * @property int $ticket_id
 * @property int $company_id
 * @property string $ticket_code
 * @property string $subject
 * @property int $employee_id
 * @property string $ticket_priority
 * @property int $department_id
 * @property string $assigned_to
 * @property string $message
 * @property string $description
 * @property string $ticket_remarks
 * @property string $ticket_status
 * @property string $ticket_note
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SupportTicket extends Model
{
	protected $table = 'support_tickets';
	protected $primaryKey = 'ticket_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'department_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'ticket_code',
		'subject',
		'employee_id',
		'ticket_priority',
		'department_id',
		'assigned_to',
		'message',
		'description',
		'ticket_remarks',
		'ticket_status',
		'ticket_note',
		'legacy_created_at'
	];
}
