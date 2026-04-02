<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedClaim
 * 
 * @property int $med_claim_id
 * @property int $company_id
 * @property int $employee_id
 * @property string $dpnttype
 * @property string $sum_insured
 * @property string $description
 * @property int $added_by
 * @property string $added_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedClaim extends Model
{
	protected $table = 'med_claims';
	protected $primaryKey = 'med_claim_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'dpnttype',
		'sum_insured',
		'description',
		'added_by',
		'added_date'
	];
}
