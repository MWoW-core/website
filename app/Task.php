<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use App\Events\TaskCreated;
use App\Events\TaskDeleted;
use App\Events\TaskUpdated;
use App\Events\TaskExecuted;
use App\Events\TaskExecuting;
use Symfony\Component\Process\Process;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @package App
 * @mixin Builder
 * @property int $id
 * @property int $server_id
 * @property string $script
 * @property int $exitcode
 * @property string $output
 * @property-read Server $server
 */
class Task extends Model
{
    protected $fillable = [
        'server_id',
        'script',
        'exitcode',
        'output'
    ];

    protected $casts = [
        'output' => 'array',
        'exitcode' => 'integer'
    ];

    protected array $dispatchesEvents = [
        'created' => TaskCreated::class,
        'updated' => TaskUpdated::class,
        'deleted' => TaskDeleted::class,
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function run($script): array
    {
        return $this->execute(
            Process::fromShellCommandline((string)$script)
        );
    }

    protected function execute(Process $process): array
    {
        Event::dispatch(
            new TaskExecuting($this, $process)
        );

        $output = '';

        $process->run(static function ($type, $shellOutput) use (&$output) {
            // Skip lines like SSH "Warning: Permanently added 'IP' ..."
            if (Str::startsWith($shellOutput, 'Warning:')) {
                $output .= \trim(
                    Str::after($shellOutput, PHP_EOL)
                );
            } else {
                $output .= \trim($shellOutput);
            }
        });

        $this->recordProcessStatus(
            $output,
            $process->getExitCode()
        );

        Event::dispatch(
            new TaskExecuted($this)
        );

        return [
            $process,
            $output
        ];
    }

    protected function recordProcessStatus(string $output, int $exitcode)
    {
        $this->update([
            'exitcode' => $exitcode,
            'output' => $output
        ]);
    }
}
