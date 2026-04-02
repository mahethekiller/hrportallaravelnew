<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmpCertificateClaim
 * 
 * @property int $id
 * @property int $userid
 * @property string $certificate_name
 * @property string $certificate_doc
 * @property string $from_date
 * @property string $to_date
 * @property string $institute
 * @property string $amount
 * @property string $reimburse_amount_req
 * @property string $approved_amt
 * @property string $issued_date
 * @property string $remarks
 * @property int $added_by
 * @property string $added_date
 * @property string $last_updated
 * @property int $updated_by
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmpCertificateClaim extends Model
{
	protected $table = 'emp_certificate_claim';

	protected $casts = [
		'userid' => 'int',
		'added_by' => 'int',
		'updated_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'userid',
		'certificate_name',
		'certificate_doc',
		'from_date',
		'to_date',
		'institute',
		'amount',
		'reimburse_amount_req',
		'approved_amt',
		'issued_date',
		'remarks',
		'added_by',
		'added_date',
		'last_updated',
		'updated_by',
		'show_status'
	];
}
