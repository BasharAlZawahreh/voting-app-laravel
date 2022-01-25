<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class IdeaComments extends Component
{
    public $idea;

    protected $listenters = ['commentWasAdded'];
    public function mount(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function commentWasAdded()
    {
        $this->idea->refresh();
    }
    public function render()
    {
        return view('livewire.idea-comments', [
            'comments' => $this->idea->comments,
        ]);
    }
}
