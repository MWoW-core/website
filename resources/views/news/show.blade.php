@extends('layouts.app')

@section('content')
    <div class="flex-fill card shadow">
        <h1 class="font-weight-light card-header bg-primary">{{ $news->title }}</h1>

        @if ($news->hasMedia('images'))
            <div class="col-lg mt-4">
                <div id="images" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        @for ($i = 0; $i < $news->getMedia('images')->count(); $i++)
                            <li data-target="#images" data-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}"></li>
                        @endfor
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                        @foreach($news->getMedia('images') as $image)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ $image->getUrl() }}" alt="Image of ...">
                            </div>
                        @endforeach
                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#images" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#images" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>

                </div>
            </div>
        @endif

        <div class="card-body d-flex">
            <div class="col-lg">
                <div class="text-light mb-3">
                    <p>
                        <img src="{{ $news->creator->photo_url }}" class="dropdown-toggle-image nav-profile-photo" alt="{{__('Photo of :user', ['user' => $news->creator->name])}}"/>
                        {!! __('Written by <a href=":link">:user</a>', [
                                'link' => route('users.show', ['user' => $news->creator]),
                                'user' => $news->creator->name ?? $news->creator->account_name
                            ])
                        !!}
                    </p>
                    @if($news->category)
                        <p class="color-white">
                            <i data-feather="grid"></i>
                            {{ $news->category }}
                        </p>
                    @endif
                    <p>
                        <i data-feather="calendar"></i>
                        {{ $news->created_at->format('l, d F Y @ g:m A') }}
                    </p>
                </div>

                <hr class="divider bg-icy-blue">

                <h2 class="font-weight-light leading-normal mb-4">{{ $news->headline }}</h2>

                <span class="mb-6 leading-tight">
                    {!! $news->body !!}
                </span>
            </div>
        </div>

        <hr class="divider bg-icy-blue">

        @livewire('comments', ['modelClass' => get_class($news), 'modelKey' => $news->id])
    </div>
@endsection
