<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExpenseType
 * 
 * @property int $expense_type_id
 * @property int $company_id
 * @property string $name
 * @property bool $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ExpenseType extends Model
{
	protected $table = 'expense_type';
	protected $primaryKey = 'expense_type_id';

	protected $casts = [
		'company_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'company_id',
		'name',
		'status',
		'legacy_created_at'
	];
}
