<?php

namespace App\Http\Livewire;

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
