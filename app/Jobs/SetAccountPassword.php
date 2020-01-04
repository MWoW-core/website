<?php

namespace App\Jobs;

use App\Realm;
use App\Scripts\CreateAccountScript;
use App\Scripts\SetAccountPasswordScript;
use App\Server;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use function decrypt;

class SetAccountPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Server $server;
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
        foreach ($this->server->realms as $realm) {
            $script = $this->createScript();

            $this->configureScript($script, $realm);

            $this->server->run($script);
        }
    }

    protected function createScript(): SetAccountPasswordScript
    {
        return new SetAccountPasswordScript(
            $this->accountName,
            decrypt($this->encryptedPassword)
        );
    }

    protected function configureScript(SetAccountPasswordScript $script, Realm $realm)
    {
        if ($realm->admin_name) {
            $script->adminName = $realm->admin_name;
        }

        if ($realm->admin_password) {
            $script->adminPassword = $realm->admin_password;
        }

        $script->sshAs = $realm->server->ssh_user;
        $script->address = $realm->console_address;
        $script->port = $realm->console_port;
    }
}
