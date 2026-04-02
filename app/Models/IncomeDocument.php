<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IncomeDocument
 * 
 * @property int $id
 * @property string $doc_type
 * @property string $file
 * @property string $financial_year
 * @property int $added_by
 * @property string $added_date
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class IncomeDocument extends Model
{
	protected $table = 'income_documents';

	protected $casts = [
		'added_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'doc_type',
		'file',
		'financial_year',
		'added_by',
		'added_date',
		'show_status'
	];
}
