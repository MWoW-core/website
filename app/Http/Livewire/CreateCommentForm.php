<?php

namespace App\Http\Livewire;

use App\Comment;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\PassPublicPropertiesToView;

class CreateCommentForm extends Component
{
    use PassPublicPropertiesToView;

    public string $comment = '';

    public string $modelClass;

    /**
     * @var string|int
     */
    public $modelKey;

    public function mount($params)
    {
        $this->modelClass = $params['modelClass'];
        $this->modelKey = $params['modelKey'];
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'comment' => 'string|max:255'
        ]);
    }

    public function submit()
    {
        $validated = $this->validate([
            'comment' => 'required|min:3|max:255'
        ]);

        $comment = $this->resolveModel()->comment($validated['comment']);

        $this->comment = '';

        $this->emit('CommentCreated', $comment);
    }

    public function render()
    {
        return view('livewire.create-comment-form');
    }

    /**
     * @return HasComments
     */
    public function resolveModel()
    {
        return $this->modelClass::findOrFail($this->modelKey);
    }
}
