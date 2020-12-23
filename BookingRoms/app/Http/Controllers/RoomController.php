<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Room;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = new Room;

        $listRooms = $rooms->get();
        
        return view('room.index',['rooms' => $listRooms]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('room.create');
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
            return redirect('room/create')
                        ->withErrors($validator)
                        ->withInput();
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
            
            return $request->wantsJson()
                        ? new Response('Gagal Proses Data', 201)
                        : redirect('room/');


        } catch (Exception $e) {
           return redirect('room/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        return View('room.index');
    }

    public function ListRoom(){
        $rooms = new Room;

        $listRooms = $rooms->get();
        
        return view('room.list',['rooms' => $listRooms]); 
    }
}
