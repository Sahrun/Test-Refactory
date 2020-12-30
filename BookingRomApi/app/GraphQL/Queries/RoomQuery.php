<?php
namespace App\GraphQL\Queries;

use Closure;
use App\Room;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class RoomQuery extends Query
{
    protected $attributes = [
        'name' => 'rooms',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('room'));
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
            'room_name' => ['name' => 'room_name', 'type' => Type::string()],
            'room_capacity' => ['name' => 'room_capacity', 'type' => Type::string()],
            'photo' => ['name' => 'photo', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if (isset($args['id'])) {
            return Room::where('id' , $args['id'])->get();
        }

        if (isset($args['room_name'])) {
            return Room::where('room_name', $args['room_name'])->get();
        }

        if(isset($args['room_capacity'])){
            return Room::where('room_capacity', $args['room_capacity'])->get();
        }

        return Room::all();
    }
}
