<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ThemeSetting
 * 
 * @property int $theme_settings_id
 * @property string $fixed_layout
 * @property string $fixed_footer
 * @property string $boxed_layout
 * @property string $page_header
 * @property string $footer_layout
 * @property string $statistics_cards
 * @property string $statistics_cards_background
 * @property string $employee_cards
 * @property string $card_border_color
 * @property string $compact_menu
 * @property string $flipped_menu
 * @property string $right_side_icons
 * @property string $bordered_menu
 * @property string $form_design
 * @property int $is_semi_dark
 * @property string $semi_dark_color
 * @property string $top_nav_dark_color
 * @property string $menu_color_option
 * @property string $export_orgchart
 * @property string $export_file_title
 * @property string $org_chart_layout
 * @property string $org_chart_zoom
 * @property string $org_chart_pan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ThemeSetting extends Model
{
	protected $table = 'theme_settings';
	protected $primaryKey = 'theme_settings_id';
	public $incrementing = false;

	protected $casts = [
		'theme_settings_id' => 'int',
		'is_semi_dark' => 'int'
	];

	protected $fillable = [
		'fixed_layout',
		'fixed_footer',
		'boxed_layout',
		'page_header',
		'footer_layout',
		'statistics_cards',
		'statistics_cards_background',
		'employee_cards',
		'card_border_color',
		'compact_menu',
		'flipped_menu',
		'right_side_icons',
		'bordered_menu',
		'form_design',
		'is_semi_dark',
		'semi_dark_color',
		'top_nav_dark_color',
		'menu_color_option',
		'export_orgchart',
		'export_file_title',
		'org_chart_layout',
		'org_chart_zoom',
		'org_chart_pan'
	];
}
