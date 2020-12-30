<?php

namespace App\GraphQL\Mutations;

use Closure;
use App\Room;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CreateRoomMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createRoom'
    ];

    public function type(): Type
    {
        return GraphQL::type('room');
    }

    public function args(): array
    {
        return [
            'room_name' => ['name' => 'room_name', 'type' => Type::nonNull(Type::string())],
            'room_capacity' => ['name' => 'room_capacity','type' => Type::nonNull(Type::string())],
            'photo' => ['name' => 'photo', 'type' => GraphQL::type('File')]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $file = $args['photo'];
        $ext = $file->extension();
        $filename = uniqid(rand(), true) . '.' .$ext;
        $upload =  Storage::disk('google')->put($filename, file_get_contents($file));
         
        if($upload){

            $room = Room::create([
                'room_name'     =>  $args['room_name'],
                'room_capacity' => $args['room_capacity'],
                'photo'         =>  $filename ,
                'created_at'    => Carbon::now()
           
            ]);

            return $room;
        }
        
        return null;
    }
}