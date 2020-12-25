<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    public $successStatus = 200;
    public $success ="OK";
    public $statusBad =400;
    public $bad ="Bad";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $data = $request->all();
        
        $bookingRoom =  Booking::join('rooms as rom', 'rom.id', '=', 'bookings.room_id')
            ->select('bookings.*', 'rom.room_name AS room_name','rom.room_capacity AS room_capacity','rom.photo AS photo')
            ->where('bookings.user_id',$data['user_id'])->get();

        return response()->json(['success'=> $this-> success,'data' =>  $bookingRoom  ], $this->successStatus);
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

        return response()->json(['success'=> $this-> success,'data' => $viewdata ], $this->successStatus);
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
            return response()->json(['bad'=> $this->bad], $this->statusBad);
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

        return response()->json(['bad'=> $this->bad], $this->statusBad);
       }

        try {

            Booking::create([
                    'user_id' => $data['user_id'],
                    'room_id' => $data['room_id'],
                    'total_person' => $data['total_person'],
                    'booking_time' => $data['booking_time'],
                    'noted' => $data['noted'],
                    'created_at' => Carbon::now(),
            ]);
            
            $user = User::where('id',$data['user_id'])->first();

            $data = array('name' => $user->email,'room_name' => $data['room_name'], 'date_book' => $data['booking_time']);

            Mail::to($user->email)->send(new SendEmail($data));

            return response()->json(['success'=> $this->success ], $this->successStatus);


        } catch (Exception $e) {
            return response()->json(['bad'=> $this->bad], $this->statusBad);
        }
    }

    public function show(Request $request){

        if(!isset($request['bookingId'])){
            return response()->json(['bad'=> $this->bad], $this->statusBad);
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

          return response()->json(['success'=> $this->success ,'data' => $bookingRoom,'type'=>$typein], $this->successStatus);

        }catch(Exception $ex){
            return response()->json(['bad'=> $this->bad], $this->statusBad);
        }
    }


    public function inout(Request $request)
    {
        try {
            $data = $request->all();

            $booking = Booking::find($data['bookingId']);

            $room = Room::find( $booking->room_id);

            if($booking == null){
                return response()->json(['bad'=> $this->bad], $this->statusBad);
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

                return response()->json(['bad'=> $this->bad], $this->statusBad);
            }

            $booking->updated_at = Carbon::now();

            $booking->save();

            return response()->json(['success'=> $this->success], $this->successStatus);

        }catch(Exception $ex){
            return response()->json(['bad'=> $this->bad], $this->statusBad);

        }
    }
    public function TestSendMail(){
        $data = array('name' => 'text','room_name' => 'test', 'date_book' =>'text');

        Mail::to("sahrunnawawi995@gmail.com")->send(new SendEmail($data));

    }
}
