<?php

use App\Customer;
use App\Email;
use App\Phone;
use Illuminate\Database\Seeder;

class CustomerDuplicatesSeeder extends Seeder
{
    public function run()
    {
        Customer::unguard();

        $faker = Faker\Factory::create();

        $customers = Customer::query()
            ->orderBy(\DB::raw('rand()'))
            ->take(rand(3, 20))->get();

        foreach ($customers as $customer) {
            $customer = Customer::create(
                array_only(
                    $customer->toArray(),
                    ['first_name', 'last_name']
                )
            );

            if (rand(0, 1)) {
                Email::create([
                    'entity_id' => $customer->id,
                    'address' => $faker->email
                ]);
            }

            if (rand(0, 1)) {
                Phone::create(
                    [
                        'entity_id' => $customer->id,
                        'number' => $faker->phoneNumber
                    ]
                );
            }
        }
    }
}