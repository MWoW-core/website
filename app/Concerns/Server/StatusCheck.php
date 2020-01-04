<?php

namespace App\Concerns\Server;

use App\Enums\ServerStatus;
use JJG\Ping;
use Throwable;

trait StatusCheck
{
    public function statusCheck()
    {
        if ($this->ping() === false) {
            $this->changeStatus(ServerStatus::Offline());
        } else {
            $this->changeStatus(ServerStatus::Online());
        }
    }

    public function ping(): bool
    {
        try {
            $latency = (new Ping($this->realmlist))->ping();

            $this->update(['latency' => "{$latency} ms"]);

            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }

    public function changeStatus(ServerStatus $status)
    {
        $this->update([
            'status' => (string)$status
        ]);
    }
}
