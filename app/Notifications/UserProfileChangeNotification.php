<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserProfileChangeNotification extends Notification
{
    use Queueable;

    protected $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Profile change by user')
            ->line('User: ' . $this->username)
            ->line('This user has made changes to his/her profile, please check the logs');
    }
}
