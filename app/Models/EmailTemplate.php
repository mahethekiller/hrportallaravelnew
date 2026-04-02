<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailTemplate
 * 
 * @property int $template_id
 * @property string $template_code
 * @property string $name
 * @property string $subject
 * @property string $message
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmailTemplate extends Model
{
	protected $table = 'email_template';
	protected $primaryKey = 'template_id';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'template_code',
		'name',
		'subject',
		'message',
		'status'
	];
}
