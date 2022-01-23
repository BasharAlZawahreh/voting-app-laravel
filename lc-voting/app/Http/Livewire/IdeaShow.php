<?php

namespace App\Http\Livewire;

use App\Exceptions\DublicateVoteException;
use App\Exceptions\VoteNotFoundException;
use App\Models\Idea;
use App\Models\User;
use Livewire\Component;

class IdeaShow extends Component
{
    public $idea;
    public $votesCount;
    public $hasVoted;
    protected $listeners = ['statusWasUpdated'];

    public function mount(Idea $idea, $votesCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $user = User::find(auth()->id());
        $this->hasVoted = $idea->isVotedByUser($user);

    }

    public function statusWasUpdated()
    {
        $this->idea->refresh();
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
                $this->idea->vote(User::find(auth()->id()));
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
