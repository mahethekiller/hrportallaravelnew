<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentType
 * 
 * @property int $document_type_id
 * @property int $company_id
 * @property string $document_type
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DocumentType extends Model
{
	protected $table = 'document_type';
	protected $primaryKey = 'document_type_id';

	protected $casts = [
		'company_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'document_type',
		'legacy_created_at'
	];
}
