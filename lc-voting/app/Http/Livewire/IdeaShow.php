<?php

namespace App\Http\Livewire;

use App\Exceptions\DublicateVoteException;
use App\Exceptions\VoteNotFoundException;
use App\Models\Idea;
use Livewire\Component;

class IdeaShow extends Component
{
    public $idea;
    public $votesCount;
    public $hasVoted;

    public function mount(Idea $idea, $votesCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->hasVoted = $idea->isVotedByUser(auth()->id());

    }

    public function vote()
    {
        if (!auth()->check()) {
            return redirect(route('login'));
        }

        if ($this->hasVoted) {
            try {
                $this->idea->unvote();
            } catch (VoteNotFoundException $e) {
                //Do Nothing
            }
            $this->hasVoted = false;
        } else {
            try {
                $this->idea->vote();
            } catch (DublicateVoteException $e) {
                //Do Nothing
            }
            $this->hasVoted = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}