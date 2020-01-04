<?php

namespace App\Http\Livewire;

use App\Server;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\PassPublicPropertiesToView;
use Livewire\WithPagination;

class ServersTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.servers-table', [
            'servers' => Server::query()->latest()->withCount('realms')->paginate()
        ]);
    }
}
