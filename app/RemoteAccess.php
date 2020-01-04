<?php

namespace App;

use Illuminate\Support\Str;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;
use React\Stream\WritableResourceStream;
use function fopen;
use function logger;
use function storage_path;
use const PHP_EOL;

/**
 * Class RemoteAccess
 *
 * Client for connecting to the telnet RA server exposed by the world server
 *
 * @package App
 */
class RemoteAccess
{
    public Realm $realm;
    public array $commands = [];

    private LoopInterface $loop;
    private Connector $connector;

    /**
     * RemoteAccess constructor.
     * @param Realm $realm
     */
    public function __construct(Realm $realm)
    {
        $this->realm = $realm;

        $this->loop = Factory::create();
        $this->connector = new Connector($this->loop);
    }

    public function command(string $command)
    {
        $this->commands[] = $command;

        return $this;
    }

    public function run()
    {
        if (empty($this->commands)) {
            return;
        }

        $logfile = new WritableResourceStream(fopen(storage_path('logs/ra.log'), 'w+'), $this->loop);

        $this->connector->connect("tcp://{$this->realm->console_address}:{$this->realm->console_port}")->then(function (ConnectionInterface $connection) use ($logfile) {
            // Log anything
            // $connection->pipe($logfile);

            $connection->on('data', function ($data) use ($connection, $logfile) {
                logger($data);

                if (Str::contains($data, 'Username')) {
                    $connection->write($this->realm->admin_name.PHP_EOL);
                }

                if (Str::contains($data, 'Password')) {
                    $connection->write($this->realm->admin_password.PHP_EOL);
                }

                if (Str::contains($data, ['fail', 'Fail'])) {
                    $logfile->write($data);
                }

                if (Str::endsWith(trim($data), '>')) {
                    foreach ($this->commands as $command) {
                        $connection->write($command.PHP_EOL);
                        logger('cmd '.$command);
                    }

                    $this->commands = [];
                    $connection->end();
                }
            });

            $connection->on('error', function ($error) use ($logfile) {
                $logfile->write('Stream ERROR: ' . $error . PHP_EOL);
            });

            $connection->on('close', function () use ($logfile) {
                $logfile->write('[CLOSED]' . PHP_EOL);
            });

        }, function ($error) use ($logfile) {
            $logfile->write('Connection ERROR: ' . $error . PHP_EOL);
        });

        $this->loop->run();
    }
}
