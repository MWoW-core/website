<?php


namespace App;

use Illuminate\Support\Str;
use function dump;
use function end;
use function fclose;
use function fgets;
use function fsockopen;
use RuntimeException;
use function fwrite;
use function is_resource;
use function sleep;
use function tap;
use function trim;
use const PHP_EOL;

class Telnet
{
    public Realm $realm;

    public int $timeout = 5;

    /**
     * @var resource
     */
    public $connection;
    public array $buffer = [];

    public int $errorCode = 0;
    public string $errorMessage = '';

    public static function send(string $command, Realm $toRealm): Telnet
    {
        return tap(new static($toRealm), function (Telnet $telnet) use ($command) {
            $telnet
                ->connect()
                ->login()
                ->write($command)
                ->read()
                ->close();
        });
    }

    /**
     * Telnet constructor.
     * @param Realm $realm
     */
    public function __construct(Realm $realm)
    {
        $this->realm = $realm;
    }

    /**
     * Ensure resource is freed when this instance gets garbage collected.
     */
    public function __destruct()
    {
        $this->close();
    }

    public function connect(): Telnet
    {
        $this->connection = fsockopen($this->realm->console_address, $this->realm->console_port, $this->errorCode, $this->errorMessage, $this->timeout);

        if ($this->connection === false) {
            throw new RuntimeException("Failed connecting on [tcp://{$this->realm->console_address}:{$this->realm->console_port}] is the server running and configured to listen using RA?");
        }

        $this->read();

        return $this;
    }

    public function login(): Telnet
    {
        $this->write($this->realm->admin_name);
        $this->write($this->realm->admin_password);

        $this->read();
        if (Str::contains($lastMessage = trim(end($this->buffer)), ['>', 'Welcome', 'welcome', 'server']) === false) {
            throw new RuntimeException("Telnet::login failed. [{$lastMessage}].");
        }

        return $this;
    }

    public function read(int $bytes = 1024): Telnet
    {
        $this->buffer[] = fgets($this->connection, $bytes);

        return $this;
    }

    public function write(string $data): Telnet
    {
        fwrite($this->connection, $data.PHP_EOL);

        // Grace period to account for latency.
        sleep(1);

        return $this;
    }

    public function close(): void
    {
        if (is_resource($this->connection)) {
            fclose($this->connection);
        }
    }
}
