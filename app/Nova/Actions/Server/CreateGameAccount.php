<?php

namespace App\Nova\Actions\Server;

use App\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use function dispatch_now;
use function encrypt;

class CreateGameAccount extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $encryptedPassword = encrypt($fields->password);

        foreach ($models as $server) {
            /** @var Server $server */
            dispatch_now(new \App\Jobs\CreateGameAccount($server, $fields->account_name, $encryptedPassword));
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Account Name', 'account_name')->rules('required', 'string', 'min:3', 'max:40', 'alpha_num'),

            Text::make('Password')->rules('required', 'string', 'min:8')
        ];
    }
}
