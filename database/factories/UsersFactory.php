<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name('male'),
        'email' => $faker->email,
        'phone_number' => $faker->phoneNumber,
        'password' => bcrypt('password'),
        'email_verified_at' => Carbon::now(),
    ];
});
