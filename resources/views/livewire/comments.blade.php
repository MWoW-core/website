<div wire:init="loadComments">
    <div class="flex-fill card shadow">
        <h1 class="font-weight-light card-header bg-primary">{{ __('Comments') }}</h1>

        <div class="card-text m-4 text-icy-blue">
            @can('create', new App\Comment)
                @livewire('create-comment-form', ['modelClass' => $modelClass, 'modelKey' => $modelKey])
            @endcan
        </div>
    </div>

    <div class="d-flex" id="comments">
        <div class="col-lg p-2">
            @foreach($comments as $comment)
                <div class="flex-fill card shadow m-2 p-2">
                    <div class="text-light mb-3">
                        @if ($comment->commentator)
                            <p>
                                <img src="{{ $comment->commentator->photo_url }}"
                                     class="dropdown-toggle-image nav-profile-photo"
                                     alt="{{__('Photo of :user', ['user' => $comment->commentator->name])}}"/>
                                {!! __('Written by :user', [
                                        'user' => $comment->commentator->name
                                    ])
                                !!}
                            </p>
                        @else
                            <p>
                                <i data-feather="help-circle"></i>
                                {{ __('Guest') }}
                            </p>
                        @endif
                        <p>
                            <i data-feather="calendar"></i>
                            {{ $comment->created_at->format('l, d F Y @ g:m A') }}
                        </p>
                    </div>

                    <p class="card-text">
                        {{ $comment->comment }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    {{ $comments->links() }}
</div>
