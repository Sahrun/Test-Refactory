<?php

namespace App\GraphQL\Types;

use App\Booking;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class BookingType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'booking',
        'description'   => 'A room',
        'model'         => Booking::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the booking'
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'The relasion user with user_id'
            ],
            'room_id' => [
                'type' => Type::int(),
                'description' => 'The relasion room with room_id',
            ],
            'total_person' => [
                'type' => Type::int(),
                'description' => 'The total person of the booking room',
                'resolve' => function($root,$args){
                    return strtolower($root->total_person);
                }
            ],
            'booking_time' => [
                'type' => Type::string(),
                'description' => 'The booking time of the booking'
            ],
            'noted' => [
                'type' => Type::string(),
                'description' => 'The noted of booking room',
                'resolve' => function($root,$args){
                    return strtolower($root->noted);
                }
            ],
            'check_in_time' => [
                'type' => Type::string(),
                'description' => 'The cek in time of booking room'
            ],
            'check_out_time' => [
                'type' => Type::string(),
                'description' => 'The cek out time of booking room'
            ],
            'user' => [
                'type'        => GraphQL::type('user'),
                'description' => 'The relationship the user'
            ],
            'room' => [
                'type' => GraphQL::type('room'),
                'description' => 'The relationship the room',
            ]
        ];
    }
    // protected function resolveEmailField($root, $args)
    // {
    //     return strtolower($root->room_name);
    // }
}

