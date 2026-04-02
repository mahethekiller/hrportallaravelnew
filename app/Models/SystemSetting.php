<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemSetting
 * 
 * @property int $setting_id
 * @property string $application_name
 * @property string $default_currency
 * @property string $default_currency_symbol
 * @property string $show_currency
 * @property string $currency_position
 * @property string $notification_position
 * @property string $notification_close_btn
 * @property string $notification_bar
 * @property string $enable_registration
 * @property string $login_with
 * @property string $date_format_xi
 * @property string $support_email
 * @property string $employee_manage_own_contact
 * @property string $employee_manage_own_profile
 * @property string $employee_manage_own_qualification
 * @property string $employee_manage_own_work_experience
 * @property string $employee_manage_own_document
 * @property string $employee_manage_own_picture
 * @property string $employee_manage_own_social
 * @property string $employee_manage_own_bank_account
 * @property string $enable_attendance
 * @property string $enable_clock_in_btn
 * @property string $enable_email_notification
 * @property string $payroll_include_day_summary
 * @property string $payroll_include_hour_summary
 * @property string $payroll_include_leave_summary
 * @property string $enable_job_application_candidates
 * @property string $job_logo
 * @property string $payroll_logo
 * @property int $is_payslip_password_generate
 * @property string $payslip_password_format
 * @property string $enable_profile_background
 * @property string $enable_policy_link
 * @property string $enable_layout
 * @property string $job_application_format
 * @property string $project_email
 * @property string $holiday_email
 * @property string $leave_email
 * @property string $payslip_email
 * @property string $award_email
 * @property string $recruitment_email
 * @property string $announcement_email
 * @property string $training_email
 * @property string $task_email
 * @property string $compact_sidebar
 * @property string $fixed_header
 * @property string $fixed_sidebar
 * @property string $boxed_wrapper
 * @property string $layout_static
 * @property string $system_skin
 * @property string $animation_effect
 * @property string $animation_effect_modal
 * @property string $animation_effect_topmenu
 * @property string $footer_text
 * @property string $system_timezone
 * @property string $system_ip_address
 * @property string $system_ip_restriction
 * @property string $google_maps_api_key
 * @property string $module_recruitment
 * @property string $module_travel
 * @property string $module_performance
 * @property string $module_files
 * @property string $module_awards
 * @property string $module_training
 * @property string $module_inquiry
 * @property string $module_language
 * @property string $module_orgchart
 * @property string $module_accounting
 * @property string $module_events
 * @property string $module_goal_tracking
 * @property string $module_assets
 * @property string $module_projects_tasks
 * @property string $module_chat_box
 * @property string $enable_page_rendered
 * @property string $enable_current_year
 * @property string $employee_login_id
 * @property string $enable_auth_background
 * @property string|null $daily_quote
 * @property string|null $quote_author
 * @property float $expense_balance_left
 * @property string $hr_version
 * @property string $hr_release_date
 * @property string $default_from_email
 * @property string|null $enable_income_declaration
 * @property string|null $income_dec_file
 * @property string|null $income_dec_file_roi
 * @property string|null $income_doc_last_date
 * @property string|null $income_dec_file_ixcheck
 * @property string|null $income_dec_file_xtra
 * @property string $updated_at
 * @property Carbon|null $created_at
 *
 * @package App\Models
 */
class SystemSetting extends Model
{
	protected $table = 'system_setting';
	protected $primaryKey = 'setting_id';

	protected $casts = [
		'is_payslip_password_generate' => 'int',
		'expense_balance_left' => 'float'
	];

	protected $fillable = [
		'application_name',
		'default_currency',
		'default_currency_symbol',
		'show_currency',
		'currency_position',
		'notification_position',
		'notification_close_btn',
		'notification_bar',
		'enable_registration',
		'login_with',
		'date_format_xi',
		'support_email',
		'employee_manage_own_contact',
		'employee_manage_own_profile',
		'employee_manage_own_qualification',
		'employee_manage_own_work_experience',
		'employee_manage_own_document',
		'employee_manage_own_picture',
		'employee_manage_own_social',
		'employee_manage_own_bank_account',
		'enable_attendance',
		'enable_clock_in_btn',
		'enable_email_notification',
		'payroll_include_day_summary',
		'payroll_include_hour_summary',
		'payroll_include_leave_summary',
		'enable_job_application_candidates',
		'job_logo',
		'payroll_logo',
		'is_payslip_password_generate',
		'payslip_password_format',
		'enable_profile_background',
		'enable_policy_link',
		'enable_layout',
		'job_application_format',
		'project_email',
		'holiday_email',
		'leave_email',
		'payslip_email',
		'award_email',
		'recruitment_email',
		'announcement_email',
		'training_email',
		'task_email',
		'compact_sidebar',
		'fixed_header',
		'fixed_sidebar',
		'boxed_wrapper',
		'layout_static',
		'system_skin',
		'animation_effect',
		'animation_effect_modal',
		'animation_effect_topmenu',
		'footer_text',
		'system_timezone',
		'system_ip_address',
		'system_ip_restriction',
		'google_maps_api_key',
		'module_recruitment',
		'module_travel',
		'module_performance',
		'module_files',
		'module_awards',
		'module_training',
		'module_inquiry',
		'module_language',
		'module_orgchart',
		'module_accounting',
		'module_events',
		'module_goal_tracking',
		'module_assets',
		'module_projects_tasks',
		'module_chat_box',
		'enable_page_rendered',
		'enable_current_year',
		'employee_login_id',
		'enable_auth_background',
		'daily_quote',
		'quote_author',
		'expense_balance_left',
		'hr_version',
		'hr_release_date',
		'default_from_email',
		'enable_income_declaration',
		'income_dec_file',
		'income_dec_file_roi',
		'income_doc_last_date',
		'income_dec_file_ixcheck',
		'income_dec_file_xtra'
	];
}
