<?php
namespace App\GraphQL\Queries;

use Closure;
use App\Booking;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class BookingQuery extends Query
{
    protected $attributes = [
        'name' => 'bookings',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('booking'));
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
            'user_id' => ['name' => 'user_id', 'type' => Type::int()],
            'room_id' => ['name' => 'room_id', 'type' => Type::int()],
            'total_person' => ['name'=> 'total_person', 'type' => Type::int()],
            'booking_time' => ['name'=> 'booking_time','type' => Type::string()],
            'noted' => ['name' => 'noted', 'type' => Type::string()],
            'check_in_time' => ['name' => 'check_in_time','type' => Type::string()],
            'check_out_time' => ['name' => 'check_out_time', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if (isset($args['id'])) {
            return Booking::where('id' , $args['id'])->get();
        }

        if (isset($args['total_person'])) {
            return Booking::where('total_person', $args['total_person'])->get();
        }

        if(isset($args['booking_time'])){
            return Booking::where('booking_time', $args['booking_time'])->get();
        }

        if(isset($args['noted'])){
            return Booking::where('noted', $args['noted'])->get();
        }

        if(isset($args['check_in_time'])){
            return Booking::where('check_in_time', $args['check_in_time'])->get();
        }

        if(isset($args['check_out_time'])){
            return Booking::where('check_out_time', $args['check_out_time'])->get();
        }
        if(isset($args['user_id'])){
            return Booking::where('user_id','=',$args['user_id'])->get();
        }


        return Booking::all();
    }
}
