<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\Response;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notification;
use Livewire\Component;

class CommentNotifications extends Component
{
    const NOTIFICATIONS_THRESHOLD = 20;
    public $notifications;
    public $notificationCount;
    public $isLoading;

    protected $listeners = ['getNotifications'];

    public function mount()
    {
        $this->notifications = collect([]);
        $this->getNotificationCount();
        $this->isLoading = true;
    }

    public function getNotifications()
    {
        $this->notifications = auth()->user()
            ->unreadNotifications()
            ->latest()
            ->take(self::NOTIFICATIONS_THRESHOLD)
            ->get();

        $this->isLoading = false;
    }

    public function markAllAsRead()
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        auth()->user()->unreadNotifications->markAsRead();
        $this->getNotificationCount();
        $this->getNotifications();
    }

    public function markAsRead($id)
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $notification = DatabaseNotification::findOrFail($id)
                        ->markAsRead();

        return $this->scrollToComment($notification);
    }

    public function scrollToComment($notification)
    {
        $idea = Idea::find($notification->data['idea_id']);
        if (!$idea) {
            session()->flash('error_message', 'This Idea is no longer exists!');
            return redirect()->route('idea.index');
        }

        $comment = Comment::find($notification->data['comment_id']);
        if (!$comment) {
            session()->flash('error_message', 'This comment is no longer exists!');
            return redirect()->route('idea.index');
        }

        $comments = $idea->comments->pluck('id');
        $indexOfComment = $comments->search($comment->id);

        $page = (int)(($indexOfComment / $comment->getPerPge()) + 1);

        session()->flash('scrollToComment', $comment->id);

        return redirect()->route('idea.show', [
            'idea' => $notification->data['idea_slug'],
            'page' => $page
        ]);
    }

    public function getNotificationCount()
    {
        $this->notificationCount = auth()->user()->unreadNotifications()->count();

        if ($this->notificationCount > self::NOTIFICATIONS_THRESHOLD) {
            $this->notificationCount = self::NOTIFICATIONS_THRESHOLD . "+";
        }
    }

    public function render()
    {
        return view('livewire.comment-notifications');
    }
}
