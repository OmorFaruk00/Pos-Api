<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password'=>Hash::make(1234),
            'designation_id' =>\App\Models\Designation::all()->random(),
            'department_id' =>\App\Models\Department::all()->random(),
            'personal_phone_no' =>$this->faker->numerify('##########'),            
            'home_phone_no' =>$this->faker->numerify('##########'),
            'alternative_phone_no' =>$this->faker->numerify('##########'),
            'status'=>1,
            'role'=>'admin',
            'jobtype'=>'full time',
        ];
    }
}
