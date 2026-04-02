<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Asset
 * 
 * @property int $assets_id
 * @property int $assets_category_id
 * @property int $company_id
 * @property int $employee_id
 * @property string $company_asset_code
 * @property string $name
 * @property string $purchase_date
 * @property string $invoice_number
 * @property string $manufacturer
 * @property string $serial_number
 * @property string $warranty_end_date
 * @property string $asset_note
 * @property string $asset_image
 * @property int $is_working
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Asset extends Model
{
	protected $table = 'assets';
	protected $primaryKey = 'assets_id';

	protected $casts = [
		'assets_category_id' => 'int',
		'company_id' => 'int',
		'employee_id' => 'int',
		'is_working' => 'int'
	];

	protected $fillable = [
		'assets_category_id',
		'company_id',
		'employee_id',
		'company_asset_code',
		'name',
		'purchase_date',
		'invoice_number',
		'manufacturer',
		'serial_number',
		'warranty_end_date',
		'asset_note',
		'asset_image',
		'is_working',
		'legacy_created_at'
	];
}
