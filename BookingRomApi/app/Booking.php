<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [ 'user_id', 'room_id','total_person','booking_time','noted','check_in_time','check_out_time'];
}
