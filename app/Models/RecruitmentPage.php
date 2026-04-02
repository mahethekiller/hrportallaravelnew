<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecruitmentPage
 * 
 * @property int $page_id
 * @property string $page_title
 * @property string $page_details
 * @property int $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class RecruitmentPage extends Model
{
	protected $table = 'recruitment_pages';
	protected $primaryKey = 'page_id';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'page_title',
		'page_details',
		'status',
		'legacy_created_at'
	];
}
