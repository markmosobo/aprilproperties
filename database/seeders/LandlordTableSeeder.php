<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Landlord;

class LandlordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

            for ($i = 0; $i < 11; $i++) {
                Landlord::create([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'phone_no' => $faker->phoneNumber,
                    'email' => $faker->email,
                ]);
            }        
    }
}
