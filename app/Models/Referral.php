<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Referral
 * 
 * @property int $referral_id
 * @property string $name
 * @property string $email
 * @property string $resume
 * @property string $contact_no
 * @property int $assigned_to
 * @property int $added_by
 * @property string $added_date
 * @property string $description
 * @property string $status
 * @property string $remarks
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Referral extends Model
{
	protected $table = 'referrals';
	protected $primaryKey = 'referral_id';

	protected $casts = [
		'assigned_to' => 'int',
		'added_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'name',
		'email',
		'resume',
		'contact_no',
		'assigned_to',
		'added_by',
		'added_date',
		'description',
		'status',
		'remarks',
		'show_status'
	];
}
