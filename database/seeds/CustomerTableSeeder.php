<?php

use App\Customer;
use App\Email;
use App\Phone;
use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('customers')->truncate();

        $faker = Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $customer = Customer::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName
            ]);

            Email::create([
                'entity_id' => $customer->id,
                'address' => $faker->email
            ]);

            Phone::create([
                'entity_id' => $customer->id,
                'number' => $faker->phoneNumber
            ]);
        }
    }
}