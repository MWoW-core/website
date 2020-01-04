<?php

namespace App\Console\Commands;

use App\Enums\ServerStatus;
use App\Server;
use Illuminate\Console\Command;

class ServersStatusCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'servers:status-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ping and update the server status';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (Server::query()->cursor() as $server) {
            /** @var Server $server */
            $server->statusCheck();
        }
    }
}
