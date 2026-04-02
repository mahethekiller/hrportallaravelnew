<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Document
 * 
 * @property int $file_id
 * @property string|null $company_id
 * @property string $file_type
 * @property string $file_desc
 * @property int $user_id
 * @property string $file_name
 * @property string $file_extension
 * @property string $file_size
 * @property string $added_date
 * @property int $added_by
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Document extends Model
{
	protected $table = 'documents';
	protected $primaryKey = 'file_id';

	protected $casts = [
		'user_id' => 'int',
		'added_by' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'company_id',
		'file_type',
		'file_desc',
		'user_id',
		'file_name',
		'file_extension',
		'file_size',
		'added_date',
		'added_by',
		'active'
	];
}
