<?php

namespace App\Events;

use App\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskExecuting
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Task $model;

    public Process $process;

    /**
     * Create a new event instance.
     *
     * @param Task $model
     * @param Process $process
     */
    public function __construct($model, $process)
    {
        $this->model = $model;
        $this->process = $process;
    }
}
