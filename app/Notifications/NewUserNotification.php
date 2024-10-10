<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    // Define which channels the notification should be sent through
    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Save in database and broadcast via Pusher
    }

    // Save notification in the database
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'New user registered: ' . $this->user->name . ' (' . $this->user->email . ')',
            'registered_at' => now()->toDateTimeString(),
        ];
    }

    // Broadcast the notification (real-time via Pusher)
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'New user registered: ' . $this->user->name . ' (' . $this->user->email . ')',
            'registered_at' => now()->toDateTimeString(),
        ]);
    }
}
