<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConferenceRoomBooking
 * 
 * @property int $booking_id
 * @property string $room_name
 * @property string $start_time
 * @property string $end_time
 * @property string $booking_date
 * @property int $added_by
 * @property string|null $purpose
 * @property string $added_date
 * @property int $show_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ConferenceRoomBooking extends Model
{
	protected $table = 'conference_room_bookings';
	protected $primaryKey = 'booking_id';

	protected $casts = [
		'added_by' => 'int',
		'show_status' => 'int'
	];

	protected $fillable = [
		'room_name',
		'start_time',
		'end_time',
		'booking_date',
		'added_by',
		'purpose',
		'added_date',
		'show_status'
	];
}
