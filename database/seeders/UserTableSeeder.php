<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
   // protected $connection = 'EMP';
    public function run()
    {
        // DB::table('users')->insert([
        //     "name"=> "Omor Faruk",
        //     "email"=>"omor@gmail.com",
        //     "password" => Hash::make("1234")

        // ]);
        DB::table('employees')->insert([
            "name"=> "Omor Faruk",
            "email"=>"omor@gmail.com",
            "password" => Hash::make("1234"),
            "designation_id"=> "22",
            "department_id"=> "222",
            "personal_phone_no"=> "12233",
            "alternative_phone_no"=> "1232341",
            "home_phone_no"=> "1332",
            "jobtype"=> "full time",
            "created_by"=> "omor",
            "status"=> 1

        ]);

    }
}
