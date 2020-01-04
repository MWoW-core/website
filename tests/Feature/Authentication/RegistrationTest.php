<?php

namespace Tests\Feature\Authentication;

use App\Server;
use App\Enums\UserRole;
use Tests\TestCase;
use App\Jobs\CreateGameAccount;
use Illuminate\Support\Facades\Bus;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function decrypt;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testItRegistersANewUserAndQueueJobsToRegisterWithGameServers()
    {
        $this->withoutExceptionHandling();

        $BusFake = Bus::fake(CreateGameAccount::class);

        $server = factory(Server::class)->create();

        $this->post('/register', [
            'name' => 'john doe',
            'account_name' => 'john',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ])->assertRedirect('/home');

        $this->assertDatabaseHas('users', [
            'role' => UserRole::Player,
            'account_name' => 'john',
            'email' => 'john@example.com'
        ]);

        $BusFake->assertDispatched(CreateGameAccount::class, function ($job) use ($server) {
            return $job->server->is($server)
                && $job->accountName === 'john'
                && decrypt($job->encryptedPassword) === 'password';
        });
    }

    public function testValidationFailsIfNameAndAccountNameEquals()
    {
        $this->postJson('/register', [
            'name' => 'john',
            'account_name' => 'john',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ])->assertJsonValidationErrors('name');
    }
}
