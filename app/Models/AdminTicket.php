<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminTicket
 * 
 * @property int $ticket_id
 * @property string $ticket_code
 * @property string $ticket_priority
 * @property int $company_id
 * @property string $subject
 * @property int $employee_id
 * @property string $description
 * @property string $remarks
 * @property int $ticket_status
 * @property string $created_by
 * @property string|null $legacy_created_at
 * @property string $updated_date
 * @property int $show_status
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AdminTicket extends Model
{
	protected $table = 'admin_tickets';
	protected $primaryKey = 'ticket_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'ticket_status' => 'int',
		'show_status' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'ticket_code',
		'ticket_priority',
		'company_id',
		'subject',
		'employee_id',
		'description',
		'remarks',
		'ticket_status',
		'created_by',
		'legacy_created_at',
		'updated_date',
		'show_status',
		'updated_by'
	];
}
