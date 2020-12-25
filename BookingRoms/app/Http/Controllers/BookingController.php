<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\SendEmailCekIn;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $bookingRoom =  Booking::join('rooms as rom', 'rom.id', '=', 'bookings.room_id')
            ->select('bookings.*', 'rom.room_name AS room_name','rom.room_capacity AS room_capacity','rom.photo AS photo')
            ->where('bookings.user_id',Auth::id())->get();

        return View('booking.index',['bookings'=>$bookingRoom]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!isset($request['roomId'])){
            return redirect()->back();
        }

        $roomId = $request['roomId'];

        $room = Room::where('id',$roomId)->first();
            
        if($room == null)
          return redirect()->back()->with('alert','Ruangan tidak ditemukan');

        $viewdata = array(
            'room_id' => $room->id,
            'room_name' => $room->room_name,
            'room_capacity' => $room->room_capacity,
            'room_photo' => $room->photo,
            'booking_time' => null,
            'total_person' =>'',
            'noted' => '',
        );

        return View('booking.now',['viewdata' => $viewdata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function now(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'total_person' => ['required','numeric']
        ]);

        if ($validator->fails()) {
            return redirect('room/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->all();

       if($data['total_person'] > $data['room_capacity']){

            $room = Room::where('id',$data['room_id'])->first();

            $viewdata = array(
                'room_id' => $room->id,
                'room_name' => $room->room_name,
                'room_capacity' => $room->room_capacity,
                'room_photo' => $room->photo,
                'booking_time' => $data['booking_time'],
                'total_person' => $data['total_person'],
                'noted' => $data['noted'],
                'total_person_invalid' => 'too many people'
            );

            return View('booking.now',['viewdata' => $viewdata]);
       }

        try {

            Booking::create([
                    'user_id' => Auth::id(),
                    'room_id' => $data['room_id'],
                    'total_person' => $data['total_person'],
                    'booking_time' => $data['booking_time'],
                    'noted' => $data['noted'],
                    'created_at' => Carbon::now(),
            ]);
            
            $user = User::where('id',Auth::id())->first();

            $data = array('name' => $user->email,'room_name' => $data['room_name'], 'date_book' => $data['booking_time']);

            Mail::to($user->email)->send(new SendEmail($data));

            return $request->wantsJson()
                        ? new Response('Gagal Proses Data', 201)
                        : redirect('room/');


        } catch (Exception $e) {
           return redirect('booking/now')
                        ->withErrors($validator)
                        ->withInput();
        }
    }

    public function show(Request $request){

        if(!isset($request['bookingId'])){
            return redirect()->back();
        }

        try{
            $typein = "";

            $bookingRoom =  Booking::join('rooms as rom', 'rom.id', '=', 'bookings.room_id')
            ->select('bookings.*', 'rom.room_name AS room_name','rom.room_capacity AS room_capacity','rom.photo AS photo')
            ->where('bookings.id',$request['bookingId'])->first();

            if(date('Y-m-d') >= date('Y-m-d', strtotime($bookingRoom->booking_time))  && !isset($bookingRoom->check_in_time)){

                $typein ='cek-in';

            }else if( date('Y-m-d')  >= date('Y-m-d', strtotime($bookingRoom->booking_time)) && isset($bookingRoom->check_in_time))
            {
                if(!isset($bookingRoom->check_out_time)){

                    $typein ='cek-out';

                }
            }
          return view('booking.viewbooking',['viewdata' => $bookingRoom,'type'=>$typein]);

        }catch(Exception $ex){
            echo "<script>";
            echo "alert('Terjadi Kesalahan');";
            echo "</script>";
            return redirect()->back(); 
        }
    }


    public function inout(Request $request)
    {
        try {
            $data = $request->all();

            $booking = Booking::find($data['bookingId']);

            $room = Room::find( $booking->room_id);

            if($booking == null){
                echo "<script>";
                echo "alert('Data booking tidak di temukan');";
                echo "</script>";

                return redirect()->back(); 
            }

            $booking = Booking::find($data['bookingId']);

            if($data['type_in'] == 'cek-in'){

                $booking->check_in_time = Carbon::now();

                $user = User::where('id',Auth::id())->first();

                $data = array('name' => $user->email,'room_name' => $room->room_name, 'cekin_date' => date('d-m-Y'),'inout_type' => 'Cek In');
    
                Mail::to($user->email)->send(new SendEmailCekIn($data));


            }else if($data['type_in'] == "cek-out")
            {

                $booking->check_out_time = Carbon::now();

                $user = User::where('id',Auth::id())->first();

                $data = array('name' => $user->email,'room_name' => $room->room_name, 'cekin_date' => date('d-m-Y'),'inout_type' => 'Cek Out');
    
                Mail::to($user->email)->send(new SendEmailCekIn($data));

            }else{

                echo "<script>";
                echo "alert('Data Tidak falid');";
                echo "</script>";

                return redirect()->back(); 
            }

            $booking->updated_at = Carbon::now();

            $booking->save();

            return redirect('/booking');

        }catch(Exception $ex){
            echo "<script>";
            echo "alert('Terjadi Kesalahan');";
            echo "</script>";
            return redirect()->back(); 

        }
    }

    public function TestSendMail(){
        $data = array('name' => 'text','room_name' => 'test', 'date_book' =>'text');

        Mail::to("sahrunnawawi995@gmail.com")->send(new SendEmail($data));

    }
}
