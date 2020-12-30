<?php

namespace App\GraphQL\Mutations;

use Closure;
use App\Booking;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class BookingNowMutation extends Mutation
{
    protected $attributes = [
        'name' => 'BookingNow'
    ];

    public function type(): Type
    {
        return GraphQL::type('booking');
    }

    public function args(): array
    {
        return [
            'user_id' => ['name' => 'user_id','type' => Type::nonNull(Type::int())],
            'room_id' => ['name' => 'room_id', 'type' => Type::nonNull(Type::int())],
            'total_person' => ['name' => 'total_person','type' => Type::nonNull(Type::int())],
            'booking_time' => ['name' => 'booking_time','type' => Type::nonNull(Type::string())],
            'noted' => ['name' => 'noted', 'type' => Type::nonNull(Type::string())],


        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
         
            $booking = Booking::create([
                'user_id'      => $args['user_id'],
                'room_id'      => $args['room_id'],
                'total_person' => $args['total_person'] ,
                'booking_time' => $args['booking_time'],
                'noted'        => $args['noted'],
                'created_at'   => Carbon::now(),
            ]);

            return $booking;
    }
}