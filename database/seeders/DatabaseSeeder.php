<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserTableSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this->call(UserTableSeeder::class);
        \App\Models\Department::factory(10)->create();
        \App\Models\Designation::factory(10)->create();
        \App\Models\Employee::factory()->create();
        \App\Models\Brand::factory(10)->create();
        \App\Models\CustomerCategory::factory(5)->create();
        \App\Models\Customer::factory(20)->create();
        \App\Models\Supplier::factory(20)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Unit::factory(3)->create();
        \App\Models\Product::factory(20)->create();
        \App\Models\ProductStock::factory(200)->create();

    }
}
