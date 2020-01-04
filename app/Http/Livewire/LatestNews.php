<?php

namespace App\Http\Livewire;

use App\News;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\PassPublicPropertiesToView;
use Livewire\WithPagination;

class LatestNews extends Component
{
    use WithPagination, PassPublicPropertiesToView;

    public ?string $category = null;

    public function render()
    {
        $this->validate([
            'category' => 'nullable|string|exists:news,category'
        ]);

        return view('livewire.latest-news')
            ->with('news', News::query()
                ->latest()
                ->when($this->category, fn ($query, $category) => $query->where('category', $category))
                ->withCount('comments')
                ->paginate(5)
            )
            ->with('categories', News::query()->distinct()->pluck('category'));
    }
}
