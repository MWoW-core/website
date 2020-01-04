<?php

namespace App\Http\Livewire;

use App\Comment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\PassPublicPropertiesToView;
use Livewire\WithPagination;
use function tap;

class Comments extends Component
{
    use PassPublicPropertiesToView, WithPagination;

    protected $listeners = ['CommentCreated' => 'render'];

    public string $modelClass;

    /**
     * @var string|int
     */
    public $modelKey;

    public bool $readyToLoad = false;

    public function loadComments()
    {
        $this->readyToLoad = true;
    }

    public function mount($params)
    {
        $this->modelClass = $params['modelClass'];
        $this->modelKey = $params['modelKey'];
    }

    public function render()
    {
        return tap(view('livewire.comments'), function (View $view) {
            if ($this->readyToLoad) {
                $view->with('comments', Comment::with('commentator')
                    ->where('commentable_type', $this->modelClass)
                    ->where('commentable_id', $this->modelKey)
                    ->latest()
                    ->paginate(5)
                );
            } else {
                $view->with('comments', new LengthAwarePaginator([], 0, 5));
            }
        });
    }
}
