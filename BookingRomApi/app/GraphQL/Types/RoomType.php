<?php

namespace App\GraphQL\Types;

use App\Room;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class RoomType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'room',
        'description'   => 'A room',
        'model'         => Room::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The id of the room'
            ],
            'room_name' => [
                'type' => Type::string(),
                'description' => 'The name of room',
                'resolve' => function($root, $args) {
                    return strtolower($root->room_name);
                }
            ],
            'room_capacity' => [
                'type' => Type::string(),
                'description' => 'The capacity of the room',
            ],
            'photo' => [
                'type' => Type::string(),
                'description' => 'The photo of the room',
                'resolve' => function($root,$args){
                    return strtolower($root->photo);
                }
            ],
            'bookings' => [
                'type'          => Type::listOf(GraphQL::type('booking')),
                'description'   => 'A list of posts written by the booking',
            ]
        ];
    }
    // protected function resolveEmailField($root, $args)
    // {
    //     return strtolower($root->room_name);
    // }
}

