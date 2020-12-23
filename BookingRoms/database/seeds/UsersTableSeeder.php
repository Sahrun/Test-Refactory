<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email'      => 'admin@mail.com',
            'password'   => Hash::make('admin123'),
            'created_at' => Carbon::now(),
        ]);
    }
}
