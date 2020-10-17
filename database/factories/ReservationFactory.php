<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reservation;
use Faker\Generator as Faker;

$factory->define(Reservation::class, function (Faker $faker) {
    return [
        "user_id" => App\User::all()->random()->id,
        "ticket_id" => App\Ticket::all()->random()->id
    ];
});
