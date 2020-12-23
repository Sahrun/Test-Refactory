<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Room;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RoomController extends Controller
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
    public function index()
    {
        $rooms = new Room;

        $listRooms = $rooms->get();
        
        return response()->json(['success'=> $this-> success,'data' => $listRooms ], $this->successStatus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_name' => ['required','string'],
            'room_capacity' => ['required','numeric'],
            'photo' => ['required','file', 'max:5000'],
        ]);

        if ($validator->fails()) {
            return response()->json(['bad'=> $this->bad], $this->statusBad);
        }


        try {
            $data = $request->all();

            $file = $data['photo'];
            $ext = $file->extension();
            $filename = uniqid(rand(), true) . '.' .$ext;
            $upload =  Storage::disk('google')->put($filename, file_get_contents($file));

            if($upload){
                Room::create([
                    'room_name' => $data['room_name'],
                    'room_capacity' => $data['room_capacity'],
                    'photo' => $filename,
                    'created_at' =>  Carbon::now()
                ]);
            }

            return response()->json(['success'=> $this-> success], $this->successStatus);


        } catch (Exception $e) {
            return response()->json(['bad'=> $this->bad], $this->statusBad);
        }
    }
}
