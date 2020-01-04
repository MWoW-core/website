<?php

namespace Tests\Feature\Authentication;

use App\Account;
use App\Jobs\SetAccountPassword;
use App\Server;
use App\User;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;
use function decrypt;
use function encrypt;
use function factory;
use function resolve;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_resets_the_game_account_passwords()
    {
        $this->withoutExceptionHandling();

        $busFake = Bus::fake(SetAccountPassword::class);

        $server = factory(Server::class)->create();

        /** @var User $user */
        $user = factory(User::class)->create(['account_name' => 'testing']);
        factory(Account::class)->create([
           'user_id' => $user->id,
           'server_id' => $server->id
        ]);

        $this->post('/password/reset', [
            'token' => Password::broker()->createToken($user),
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $busFake->assertDispatched(SetAccountPassword::class, function (SetAccountPassword $job) use ($server) {
            return $job->accountName === 'testing'
                && decrypt($job->encryptedPassword) === 'password'
                && $job->server->is($server);
        });
    }
}
