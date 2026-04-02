<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LeftMenu
 * 
 * @property int $id
 * @property string $title
 * @property string $icon
 * @property string $menu_type
 * @property int $parent_id
 * @property int $access_to
 * @property int $sort_no
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LeftMenu extends Model
{
	protected $table = 'left_menu';

	protected $casts = [
		'parent_id' => 'int',
		'access_to' => 'int',
		'sort_no' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'title',
		'icon',
		'menu_type',
		'parent_id',
		'access_to',
		'sort_no',
		'show_status'
	];
}
