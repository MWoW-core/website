<div class="modal" id="modal-notifications" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                {{ __('Notifications') }}
            </div>

            <div class="modal-body">
                @if(empty($notifications))
                    <div class="notification-container">
                        <div class="alert alert-warning">
                            {{__('We don\'t have anything to show you right now! But when we do, we\'ll be sure to let you know. Talk to you soon!')}}
                        </div>
                    </div>
                @else
                    <!-- List Of Notifications -->
                    <div class="notification-container">
                        @foreach ($notifications as $notification)
                            <div class="notification">
                                <!-- Notification Icon -->
                                <figure>
                                    @if($notification->creator)
                                        <img src="{{ $notification->creator->photo_url }}" class="spark-profile-photo" alt="{{__('Creator Photo')}}" />
                                    @else
                                        <img src="{{ Storage::disk('avatars')->url('default.svg') }}" class="spark-profile-photo" alt="{{__('Default Avatar')}}" />
                                    @endif
                                </figure>

                                <!-- Notification -->
                                <div class="notification-content">
                                    <div class="meta">
                                        <p class="title">
                                            @if($notification->creator)
                                                <span v-if="notification.creator">
                                                    @{{ notification.creator.name }}
                                                </span>
                                            @else
                                                <span v-else>
                                                    {{ config('app.name') }}
                                                </span>
                                            @endif
                                        </p>

                                        <div class="date">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>

                                    <div class="notification-body">
                                        {!! (new Parsedown)->text(htmlspecialchars($notification->data)) !!}
                                    </div>

                                    <!-- Notification Action -->
                                    @if($notification->action_text)
                                        <a href="{{ $notification->action_url }}" class="btn btn-primary">
                                            {{ $notification->action_text }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <hr class="divider">
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Modal Actions -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
