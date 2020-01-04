<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Realm;
use Faker\Generator as Faker;
use App\Server;

$factory->define(Realm::class, function (Faker $faker) {
    return [
        'server_id' => factory(Server::class),
        'console_address' => '127.0.0.1',
        'console_port' => '3443',
        'expansion' => 'Wrath of The Lich King',
        'admin_name' => 'admin',
        'admin_password' => 'password'
    ];
});
