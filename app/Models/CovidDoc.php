<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CovidDoc
 * 
 * @property int $id
 * @property int $userid
 * @property string $infection_status
 * @property string $infection_report
 * @property string $recovered_status
 * @property string $recovery_report
 * @property string $infection_date
 * @property string $recovery_date
 * @property string $vaccine_status
 * @property string $vaccine_name
 * @property string $dose1_date
 * @property string $dose2_date
 * @property string $remarks
 * @property string $added_date
 * @property int $show_status
 * @property string $dose1_doc
 * @property string $dose2_doc
 * @property string|null $updated_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CovidDoc extends Model
{
	protected $table = 'covid_docs';

	protected $casts = [
		'userid' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'userid',
		'infection_status',
		'infection_report',
		'recovered_status',
		'recovery_report',
		'infection_date',
		'recovery_date',
		'vaccine_status',
		'vaccine_name',
		'dose1_date',
		'dose2_date',
		'remarks',
		'added_date',
		'show_status',
		'dose1_doc',
		'dose2_doc',
		'updated_date'
	];
}
