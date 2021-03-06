<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Http\Response;
use Livewire\Component;

class DeleteComment extends Component
{
    public ?Comment $comment;

    protected $listeners = ['setDeleteComment'];

    public function setEditComment($commentId)
    {
        $this->comment = Comment::findOrFail($commentId);

        $this->emit('deleteCommentWasSet');
    }

    public function deleteComment()
    {
        if (auth()->guest() || auth()->user()->cannot('delete', $this->idea)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        Comment::destroy($this->commen->id);
        $this->comment = null;

        $this->emit('commentWasDeleted', 'Comment Deleted Successfully!');
    }

    public function render()
    {
        return view('livewire.delete-comment');
    }
}
