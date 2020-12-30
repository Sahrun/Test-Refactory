<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Booking;
use App\EmailRemainderCekIn;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class RemainderDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remainder:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email Remainder Daily For Cek in';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $url =  \config('app.url')."/booking/view?bookingId=";
        $data = array('name' => 'text','room_name' => 'test', 'cekin_date' =>'text' ,'url' => $url);

        $bookingToday  = Booking::join('rooms as rom', 'rom.id', '=', 'bookings.room_id')
        ->join('users as user','user.id','=','bookings.user_id')
        ->select('rom.room_name AS room_name','user.email AS email','bookings.booking_time AS booking_time','bookings.id AS bookingid')
        ->where('bookings.booking_time','=',Carbon::now()->format('Y-m-d'))
        ->whereNull('bookings.check_in_time')->get();

        foreach($bookingToday AS $key => $value){
           
            $data = array('cekin_date' => $value->booking_time,
                           'url' => $url.$value->bookingid,
                           'name' => $value->email,
                           'room_name' => $value->room_name);
            Mail::to($value->email)->send(new EmailRemainderCekIn($data));
        }
    }
}
