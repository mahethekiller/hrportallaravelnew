<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Trainer
 * 
 * @property int $trainer_id
 * @property int $company_id
 * @property string $first_name
 * @property string $last_name
 * @property string $contact_number
 * @property string $email
 * @property int $designation_id
 * @property string $expertise
 * @property string $address
 * @property bool $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Trainer extends Model
{
	protected $table = 'trainers';
	protected $primaryKey = 'trainer_id';
	public $incrementing = false;

	protected $casts = [
		'trainer_id' => 'int',
		'company_id' => 'int',
		'designation_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'company_id',
		'first_name',
		'last_name',
		'contact_number',
		'email',
		'designation_id',
		'expertise',
		'address',
		'status',
		'legacy_created_at'
	];
}
