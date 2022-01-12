<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class IdeaIndex extends Component
{
    public $idea;
    public $hasVoted;

    public function mount(Idea $idea){
        $this->idea = $idea;
        $this->hasVoted = $idea->voted_by_user;

    }

    public function vote()
    {
        if (!auth()->check()) {
            return redirect(route('login'));
        }

        if ($this->hasVoted) {
            $this->idea->unvote();
            $this->votesCount--;
            $this->hasVoted = false;
        }
        else{
            $this->idea->vote();
            $this->votesCount++;
            $this->hasVoted = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-index');
    }
}
