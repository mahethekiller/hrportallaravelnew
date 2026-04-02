<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeDocument
 * 
 * @property int $document_id
 * @property int $employee_id
 * @property int $document_type_id
 * @property string $date_of_expiry
 * @property string $title
 * @property string $notification_email
 * @property bool $is_alert
 * @property string $description
 * @property string $document_file
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeDocument extends Model
{
	protected $table = 'employee_documents';
	protected $primaryKey = 'document_id';

	protected $casts = [
		'employee_id' => 'int',
		'document_type_id' => 'int',
		'is_alert' => 'bool'
	];

	protected $fillable = [
		'employee_id',
		'document_type_id',
		'date_of_expiry',
		'title',
		'notification_email',
		'is_alert',
		'description',
		'document_file',
		'legacy_created_at'
	];
}
