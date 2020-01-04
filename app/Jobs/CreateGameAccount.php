<?php

namespace App\Jobs;

use App\Realm;
use App\User;
use App\Server;
use Illuminate\Bus\Queueable;
use App\Scripts\CreateAccountScript;
use Illuminate\Contracts\Database\ModelIdentifier;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use function decrypt;

class CreateGameAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Server | ModelIdentifier
     */
    public $server;
    public string $accountName;
    public string $encryptedPassword;

    public function __construct(Server $server, string $accountName, string $encryptedPassword)
    {
        $this->server = $server;
        $this->accountName = $accountName;
        $this->encryptedPassword = $encryptedPassword;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $script = $this->createScript();

        $this->server->run($script);

        $user = User::findByAccountName($this->accountName);

        if ($user) {
            $user->accounts()->create([
                'server_id' => $this->server->getKey()
            ]);
        }
    }

    protected function createScript(): CreateAccountScript
    {
        return new CreateAccountScript(
            $this->accountName,
            decrypt($this->encryptedPassword)
        );
    }
}
