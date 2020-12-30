<?php

namespace App;

use App\User;
use App\Room;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [ 'user_id', 'room_id','total_person','booking_time','noted','check_in_time','check_out_time'];
    

    public function user()
    {
        return $this->hasOne(User::class,'id', 'user_id');
    }

    public function room()
    {
        return $this->hasOne(Room::class,'id','room_id');
    }
}
