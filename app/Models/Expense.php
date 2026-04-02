<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Expense
 * 
 * @property int $expense_id
 * @property int $employee_id
 * @property int $company_id
 * @property string $expense_name
 * @property string $billcopy_file
 * @property string $outgoing_amount
 * @property string $incoming_amount
 * @property string $balance
 * @property string $purchase_date
 * @property string $remarks
 * @property bool $status
 * @property string $status_remarks
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Expense extends Model
{
	protected $table = 'expenses';
	protected $primaryKey = 'expense_id';

	protected $casts = [
		'employee_id' => 'int',
		'company_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'employee_id',
		'company_id',
		'expense_name',
		'billcopy_file',
		'outgoing_amount',
		'incoming_amount',
		'balance',
		'purchase_date',
		'remarks',
		'status',
		'status_remarks',
		'legacy_created_at'
	];
}
