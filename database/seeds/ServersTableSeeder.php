<?php

use App\Enums\RealmExpansion;
use Illuminate\Database\Seeder;
use App\Server;
use App\Enums\ServerStatus;

class ServersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Server $server */
        $server = Server::query()->create([
            'status' => ServerStatus::Online,
            'realmlist' => env('SERVER_REALMLIST', '127.0.0.1'),
            'ssh_user' => env('SERVER_SSH_USER', 'root'),
            'ssh_address' => env('SERVER_SSH_ADDRESS', '127.0.0.1'),
            'ssh_port' => env('SERVER_SSH_PORT', 22),
            'ssh_key' => file_get_contents(env('SERVER_PRIVATE_KEY'))
        ]);

        $server->realms()->create([
            'admin_name' => env('REALM_ADMIN_NAME', 'admin'),
            'admin_password' => env('REALM_ADMIN_PASSWORD', 'admin'),
            'expansion' => RealmExpansion::WoTLK,
            'console_address' => '127.0.0.1',
            'console_port' => '3443',
        ]);
    }
}
