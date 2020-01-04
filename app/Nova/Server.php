<?php

namespace App\Nova;

use App\Enums\ServerStatus;
use App\Nova\Actions\Server\CreateGameAccount;
use App\Nova\Actions\Server\StatusCheck;
use App\Rules\ValidHostname;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use SimpleSquid\Nova\Fields\Enum\Enum;

class Server extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Server';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'realmlist';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'status', 'realmlist'
    ];

    /**
     * Get the search result subtitle for the resource.
     *
     * @return string|null
     */
    public function subtitle()
    {
        return $this->status->description;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Enum::make('Status')->attachEnum(ServerStatus::class),

            Text::make('Realmlist')->rules('required', 'string', new ValidHostname),

            Text::make('Latency'),

            Text::make('SSH User', 'ssh_user')->hideFromIndex(),

            Text::make('SSH Key', 'ssh_key')->displayUsing(fn () => __('Hidden for security reasons.'))->hideFromIndex(),

            Text::make('SSH Address', 'ssh_address')->rules(new ValidHostname)->hideFromIndex(),

            Number::make('SSH Port', 'ssh_port')->hideFromIndex(),

            HasMany::make('Tasks'),
            HasMany::make('Realms'),
            HasMany::make('Accounts')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new CreateGameAccount,
            new StatusCheck
        ];
    }
}
