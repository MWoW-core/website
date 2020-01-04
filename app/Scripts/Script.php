<?php

namespace App\Scripts;

use App\Realm;
use App\Server;
use function array_merge;
use function get_class;
use function rand;

abstract class Script
{
    /**
     * Get the name of the script.
     *
     * @return string
     */
    public static function name(): string
    {
        return static::class;
    }

    /**
     * Get the timeout for the script.
     *
     * @return int|null
     */
    public function timeout(): ?int
    {
        return 3600;
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    abstract public function contents(): string;

    /**
     * Run the script on given server
     *
     * @param Server $server
     * @return mixed
     */
    public function run(Server $server): array
    {
        $output = [];

        foreach ($server->realms as $realm) {
            /** @var Realm $realm */

            if ($server->isLocalhost() === false) {
                $server->SSH()->reverseTunnel($consolePort = rand(49152, 65535), $realm->console_port);
                $realm->console_port = $consolePort;
                $realm->console_address = '127.0.0.1';
            }

            $telnet = $realm->runScript($this);

            $output[] = [
                'handler' => get_class($telnet),
                'messages' => $telnet->buffer,
                'code' => $telnet->errorCode,
                'errors' => $telnet->errorMessage,
                'realm_id' => $realm->getKey()
            ];
        }

        return $output;
    }

    /**
     * Render the script as a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->contents();
    }
}
