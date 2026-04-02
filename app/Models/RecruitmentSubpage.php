<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecruitmentSubpage
 * 
 * @property int $subpages_id
 * @property int $page_id
 * @property string $sub_page_title
 * @property string $sub_page_details
 * @property int $status
 * @property string|null $legacy_created_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class RecruitmentSubpage extends Model
{
	protected $table = 'recruitment_subpages';
	protected $primaryKey = 'subpages_id';

	protected $casts = [
		'page_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'page_id',
		'sub_page_title',
		'sub_page_details',
		'status',
		'legacy_created_at'
	];
}
