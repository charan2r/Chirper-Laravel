<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Chirp;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewChirp extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Chirp $chirp)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject(subject: "New Chirp from {$this->chirp->user->name}")
                    ->greeting(greeting: "New Chirp from {$this->chirp->user->name}")
                    ->line(line: Str::limit(value: $this->chirp->message, limit: 50))
                    ->action(text: 'Go to Chirper', url: url(path: '/'))
                    ->line(line: 'Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
