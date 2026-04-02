<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmployeeResignation extends Model
{
	protected $table = 'employee_resignations';
	protected $primaryKey = 'resignation_id';

	protected $casts = [
		'company_id' => 'int',
		'employee_id' => 'int',
		'manager_id' => 'int',
		'sage_status' => 'int',
		'added_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'company_id',
		'employee_id',
		'manager_id',
		'notice_date',
		'resignation_date',
		'requested_notice',
		'manager_comment',
		'manager_status',
		'it_comment',
		'it_status',
		'account_status',
		'account_comment',
		'hr_comment',
		'hr_status',
		'head_status',
		'it_person',
		'account_per',
		'hr_person',
		'manager_person',
		'sage_person',
		'login_person',
		'coo_status',
		'coo_comment',
		'sage_status',
		'sage_comment',
		'employee_accept',
		'reason',
		'exit_form',
		'added_by',
		'legacy_created_at',
		'status',
		'comments',
		'show_status',
		'login_status',
		'login_comment'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'employee_id', 'user_id');
	}

	public function manager()
	{
		return $this->belongsTo(Employee::class, 'manager_id', 'user_id');
	}

	public function company()
	{
		return $this->belongsTo(Company::class, 'company_id', 'company_id');
	}

	public function addedBy()
	{
		return $this->belongsTo(Employee::class, 'added_by', 'user_id');
	}
}
