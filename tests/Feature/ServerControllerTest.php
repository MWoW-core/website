<?php

namespace Tests\Feature;

use App\Realm;
use App\Server;
use App\Enums\UserRole;
use Tests\TestCase;
use App\Enums\ServerStatus;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItListsTheServers()
    {
        factory(Server::class)->create(['realmlist' => 'login.example.com']);

        $this->get(route('servers.index'))
            ->assertViewIs('servers.index')
            ->assertSee('login.example.com');
    }
}
