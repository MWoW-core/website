<a href="#" wire:click="markAllAsRead" class="notification-pill m-2" data-toggle="modal" data-target="#modal-notifications">
    <svg class="mr-2" width="18px" height="20px" viewBox="0 0 18 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <linearGradient x1="50%" y1="100%" x2="50%" y2="0%" id="linearGradient-1">
                <stop stop-color="#86A0A6" offset="0%"></stop>
                <stop stop-color="#596A79" offset="100%"></stop>
            </linearGradient>
        </defs>
        <g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="header" transform="translate(-926.000000, -29.000000)" fill-rule="nonzero" fill="url(#linearGradient-1)">
                <g id="Group-3">
                    <path d="M929,37 C929,34.3773361 930.682712,32.1476907 933.027397,31.3318031 C933.009377,31.2238826 933,31.1130364 933,31 C933,29.8954305 933.895431,29 935,29 C936.104569,29 937,29.8954305 937,31 C937,31.1130364 936.990623,31.2238826 936.972603,31.3318031 C939.317288,32.1476907 941,34.3773361 941,37 L941,43 L944,45 L944,46 L926,46 L926,45 L929,43 L929,37 Z M937,47 C937,48.1045695 936.104569,49 935,49 C933.895431,49 933,48.1045695 933,47 L937,47 L937,47 Z"
                        id="Combined-Shape"></path>
                </g>
            </g>
        </g>
    </svg>
    {{ $unreadCount }}
</a>
