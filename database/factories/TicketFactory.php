<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ticket;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {

    $date = $faker->dateTimeBetween($startDate = 'now', $endDate = '2020-12-31');
    $date = date_format($date, 'Y-m-d');
    $start_time = Carbon::parse($date . " 08:00:00");
    $finish_time = Carbon::parse($date . " 08:00:00")->addHour(rand(2, 12));

    return [
        "day" => $date,
        "event_name" => $faker->company(),
        "quantity" => rand(10, 100),
        "start_time" => $start_time->format('Y-m-d H:i:s'),
        "finish_time" => $finish_time->format('Y-m-d H:i:s'),
    ];
});
