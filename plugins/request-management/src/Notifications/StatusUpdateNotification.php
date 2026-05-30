<?php

namespace Vendor\RequestManagement\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusUpdateNotification extends Notification
{
    use Queueable;

    protected $request;
    protected $status;

    public function __construct($request, $status)
    {
        $this->request = $request;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $statusLabel = match ($this->status) {
            3 => 'Approved',
            4 => 'Rejected',
            default => 'Updated',
        };

        return (new MailMessage)
            ->subject("Request {$statusLabel}: {$this->request->uniqueid}")
            ->line("Your request {$this->request->uniqueid} has been {$statusLabel}.")
            ->action('View Request', config('app.url'))
            ->line('Thank you for using our application!');
    }
}
