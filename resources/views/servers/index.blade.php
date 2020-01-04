@extends('layouts.app')

@section('content')
    <div class="card text-icy-blue">
        <div class="card-header text-lg">{{ __('Servers') }}</div>

        <div class="card-body">
            <div class="table-responsive">
                @livewire('servers-table')
            </div>
        </div>
    </div>
@endsection
