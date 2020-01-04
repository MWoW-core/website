<?php

namespace App;

use Symfony\Component\Process\Process;
use function implode;

class SecureShell
{
    public Server $server;

    /**
     * SecureShell constructor.
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Create a reverse tunnel to the given console port on the remote machine
     *
     * @param int $localPort
     * @param int $consolePort
     */
    public function reverseTunnel(int $localPort, int $consolePort)
    {
        $process = Process::fromShellCommandline(implode(' ', [
            'ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no ExitOnForwardFailure=yes',
            '-i '.SecureShellKey::make($this->server->ssh_key)->path(),
            '-p '.$this->server->ssh_port,
            '-R '.$localPort.':localhost:'.$consolePort,
            $this->server->ssh_user.'@'.$this->server->ssh_address,
        ]));

        $process->run();
    }
}
