<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeImmigration
 * 
 * @property int $immigration_id
 * @property int $employee_id
 * @property int $document_type_id
 * @property string $document_number
 * @property string $document_file
 * @property string $issue_date
 * @property string $expiry_date
 * @property string $country_id
 * @property string $eligible_review_date
 * @property string $comments
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeImmigration extends Model
{
	protected $table = 'employee_immigration';
	protected $primaryKey = 'immigration_id';

	protected $casts = [
		'employee_id' => 'int',
		'document_type_id' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'document_type_id',
		'document_number',
		'document_file',
		'issue_date',
		'expiry_date',
		'country_id',
		'eligible_review_date',
		'comments',
		'legacy_created_at'
	];
}
