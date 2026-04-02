<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HrsaleInvoicesItem
 * 
 * @property int $invoice_item_id
 * @property int $invoice_id
 * @property int $project_id
 * @property string $item_name
 * @property string $item_tax_type
 * @property string $item_tax_rate
 * @property string $item_qty
 * @property string $item_unit_price
 * @property string $item_sub_total
 * @property string $sub_total_amount
 * @property string $total_tax
 * @property int $discount_type
 * @property string $discount_figure
 * @property string $total_discount
 * @property string $grand_total
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class HrsaleInvoicesItem extends Model
{
	protected $table = 'hrsale_invoices_items';
	protected $primaryKey = 'invoice_item_id';

	protected $casts = [
		'invoice_id' => 'int',
		'project_id' => 'int',
		'discount_type' => 'int'
	];

	protected $fillable = [
		'invoice_id',
		'project_id',
		'item_name',
		'item_tax_type',
		'item_tax_rate',
		'item_qty',
		'item_unit_price',
		'item_sub_total',
		'sub_total_amount',
		'total_tax',
		'discount_type',
		'discount_figure',
		'total_discount',
		'grand_total',
		'legacy_created_at'
	];
}
