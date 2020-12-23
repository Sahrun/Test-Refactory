<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            [
                'room_name'      => 'Ruang Meeting 01',
                'room_capacity'  => '10',
                'created_at'     => Carbon::now()
            ],
            [
                'room_name'      => 'Ruang Meeting 02',
                'room_capacity'  => '15',
                'created_at'     => Carbon::now()
            ]
        ]);
    }
}
