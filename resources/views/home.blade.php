@extends('layouts.app')

@section('content')
    <div class="card text-icy-blue">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
            <h1>{{ __('Hello, :user', ['user' => $user->account_name]) }}</h1>

            <div class="card border-icy-blue">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Accounts') }}</h5>
                    <table class="table table-striped card-text">
                        <thead>
                            <tr>
                                <th>{{ __('Server') }}</th>
                                <th>{{ __('# Characters') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($user->accounts as $account)
                            <tr>
                                <td>
                                    <a target="_blank" href="{{ route('servers.realmlist.show', $account->server) }}" data-toggle="tooltip" title="{{ __('Download realmlist') }}">
                                        {{ $account->server->realmlist }}
                                        <i data-feather="activity" color="{{ $account->server->status->color() }}"></i>
                                    </a>
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
