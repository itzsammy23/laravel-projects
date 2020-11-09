<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'hussla_id' => Str::random(20),
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'fullname' => $faker->lastName . " " . $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'phone' => '+2349034941086',
        'businessname' => 'Aylan Plaza',
        'businessinfo' => 'Fresh Cuts',
        'businessaddress' => $faker->streetAddress,
        'businessphone' => '+2349034941086',
        'specialize' => 'Haircuts',
        'businessmotto' => 'Dope cuts',
        'state' => 'Lagos',
        'area' => 'Magodo',
        'password' => \Illuminate\Support\Facades\Hash::make('123456789'),
        'remember_token' => Str::random(10),
        'usingFreeSubscription' => 'true',
        'usingPaidSubscription' => 'false',
        'isEligible' => 'true',
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s'),
    ];
});

$factory->define(Customer::class, function (Faker $faker) {
    return [
            "firstname" => $faker->firstName,
            "lastname" => $faker->lastName,
            "email" => "itzsammy23@gmail.com",
            'password' => \Illuminate\Support\Facades\Hash::make('123456789'),
    ];
});
