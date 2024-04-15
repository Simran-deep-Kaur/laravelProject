<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 50; $i++){
            Employee::create([
                'name' => $faker->name,
                'email' => $faker->unique('employees')->safeEmail(),
                'gender' => $faker->randomElement(['male', 'female', 'other']),
                'age' =>$faker->numberBetween(18,60),
                'user_id' => 47,
            ]);
        }
    }
}
