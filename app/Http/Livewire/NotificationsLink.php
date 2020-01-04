<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\PassPublicPropertiesToView;

class NotificationsLink extends Component
{
    use PassPublicPropertiesToView;

    public int $unreadCount = 0;

    public int $readCount = 0;

    public function mount()
    {
        if (Auth::check()) {
            $this->unreadCount = Auth::user()->unreadNotifications()->count();
            $this->readCount = Auth::user()->readNotifications()->count();
        }
    }

    public function updating()
    {
        if (Auth::check()) {
            $this->unreadCount = Auth::user()->unreadNotifications()->count();
            $this->readCount = Auth::user()->readNotifications()->count();
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->each->markAsRead();
    }

    public function render()
    {
        return view('livewire.notifications-link');
    }
}
