<?php

namespace Tests\Unit;

use App\Account;
use App\Server;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function factory;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_servers_relation()
    {
        $server = factory(Server::class)->create();
        $anotherServer = factory(Server::class)->create();

        /** @var User $user */
        $user = factory(User::class)->create();
        factory(Account::class)->create([
            'user_id' => $user->getKey(),
            'server_id' => $server->id
        ]);

        self::assertTrue(
            $user->servers->contains($server)
        );

        self::assertFalse(
            $user->servers->contains($anotherServer)
        );
    }
}
