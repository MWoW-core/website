<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\ServerStatus;
use App\Server;
use Faker\Generator as Faker;

$factory->define(Server::class, static function (Faker $faker) {
    return [
        'status' => ServerStatus::getRandomValue(),
        'realmlist' => '127.0.0.1',
        'latency' => '5 ms',
        'ssh_key' => null,
        'ssh_address' => '127.0.0.1',
        'ssh_port' => 22
    ];
});

$factory->state(Server::class, 'trashed', [(new Server)->getDeletedAtColumn() => now()]);
