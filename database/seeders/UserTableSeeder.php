<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    protected $connection = 'EMP';
    public function run()
    {
        DB::table('users')->insert([
            "name"=> "Omor Faruk",
            "email"=>"omor@gmail.com",
            "password" => Hash::make("1234")

        ]);
        // DB::connection('EMP')->table('employees')->insert([
        //     "name"=> "Omor Faruk",
        //     "email"=>"omor@gmail.com",
        //     "password" => Hash::make("1234")

        // ]);
        
    }
}
