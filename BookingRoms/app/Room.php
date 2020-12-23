<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'room_name', 'room_capacity','photo'];

}
