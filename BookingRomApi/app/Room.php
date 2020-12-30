<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Booking;

class Room extends Model
{
    protected $table = 'rooms';


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'room_name', 'room_capacity','photo'];


    public function bookings(){
        return $this->hasMany(Booking::class);
    }

}
