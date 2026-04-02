<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentsIntern
 * 
 * @property int $file_id
 * @property string $title
 * @property string $file_desc
 * @property int $user_id
 * @property string $file_name
 * @property string $added_date
 * @property int $added_by
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DocumentsIntern extends Model
{
	protected $table = 'documents_intern';
	protected $primaryKey = 'file_id';

	protected $casts = [
		'user_id' => 'int',
		'added_by' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'title',
		'file_desc',
		'user_id',
		'file_name',
		'added_date',
		'added_by',
		'active'
	];
}
