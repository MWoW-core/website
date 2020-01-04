<div>
    <h1 class="font-weight-thin">
        {{ __('Latest News') }}
    </h1>
    <hr class="divider bg-light">

    <div class="form-group">
        <label for="news_category">{{ __('Category') }}</label>
        <select class="form-control" id="news_category" wire:model="category">
            @foreach($categories as $category)
                <option>{{ $category }}</option>
            @endforeach
        </select>
    </div>

    <div class="d-flex flex-column justify-content-center">
        @foreach($news as $article)
            <div class="flex-fill card shadow m-2">
                <h1 class="font-weight-light card-header bg-primary">{{ $article->title }}</h1>

                @if ($article->hasMedia('images'))
                    <div class="col-lg">
                        {{ $article->getFirstMedia('images') }}
                    </div>
                @endif

                <div class="card-body d-flex">
                    <div class="col-lg">
                        <div class="text-light mb-3">
                            <p>
                                <img src="{{ $article->creator->photo_url }}" class="dropdown-toggle-image nav-profile-photo" alt="{{__('Photo of :user', ['user' => $article->creator->name])}}"/>
                                {!! __('Written by <a href=":link">:user</a>', [
                                        'link' => route('users.show', ['user' => $article->creator]),
                                        'user' => $article->creator->name ?? $article->creator->account_name
                                    ])
                                !!}
                            </p>
                            @if($article->category)
                                <p class="color-white">
                                    <i data-feather="grid"></i>
                                    {{ $article->category }}
                                </p>
                            @endif
                            <p>
                                <i data-feather="calendar"></i>
                                {{ $article->created_at->format('l, d F Y @ g:m A') }}
                            </p>
                        </div>

                        <hr class="divider">

                        <h2 class="font-weight-light leading-normal mb-4">{{ $article->headline }}</h2>

                        <a href="{{ $article->link }}" class="mr-2">{{ __('Read more.') }}</a>

                        <a href="{{ $article->link }}#comments">
                            {{ __(':count Comments.', ['count' => $article->comments_count]) }}
                        </a>
                    </div>
                </div>
            </div>

            <hr class="divider">
        @endforeach
    </div>

    {{ $news->links() }}
</div>
