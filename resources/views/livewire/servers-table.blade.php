<table class="table table-striped text-center">
    <thead>
        <tr>
            <th>{{ __('Realmlist') }}</th>
            <th>{{ __('Latency') }}</th>
            <th>{{ __('# Realms') }}</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($servers as $server)
            <tr>
                <td>
                    <a target="_blank" href="{{ route('servers.realmlist.show', $server) }}" data-toggle="tooltip" title="{{ __('Download realmlist') }}">
                        {{ $server->realmlist }}
                        <i data-feather="activity" color="{{ $server->status->color() }}"></i>
                    </a>
                </td>
                <td>
                    {{ $server->latency }}
                </td>
                <td>
                    {{ $server->realms_count }}
                </td>
            </tr>
        @endforeach
    </tbody>

    <tfoot>
        {!! $servers->links() !!}
    </tfoot>
</table>
