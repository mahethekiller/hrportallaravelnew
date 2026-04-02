<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HrsaleInvoice
 * 
 * @property int $invoice_id
 * @property string $invoice_number
 * @property int $project_id
 * @property string $invoice_date
 * @property string $invoice_due_date
 * @property string $sub_total_amount
 * @property string $discount_type
 * @property string $discount_figure
 * @property string $total_tax
 * @property string $total_discount
 * @property string $grand_total
 * @property string $invoice_note
 * @property bool $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class HrsaleInvoice extends Model
{
	protected $table = 'hrsale_invoices';
	protected $primaryKey = 'invoice_id';

	protected $casts = [
		'project_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'invoice_number',
		'project_id',
		'invoice_date',
		'invoice_due_date',
		'sub_total_amount',
		'discount_type',
		'discount_figure',
		'total_tax',
		'total_discount',
		'grand_total',
		'invoice_note',
		'status',
		'legacy_created_at'
	];
}
