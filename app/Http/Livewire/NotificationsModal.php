<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\PassPublicPropertiesToView;

class NotificationsModal extends Component
{
    use PassPublicPropertiesToView;

    public array $notifications;

    public function mount()
    {
        $this->notifications = Auth::check()
            ? $this->user()->unreadNotifications->toArray()
            : [];
    }

    public function updating()
    {
        $this->notifications = Auth::check()
            ? Auth::user()->unreadNotifications
            : new Collection;
    }

    private function user(): ?User
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.notifications-modal');
    }
}
