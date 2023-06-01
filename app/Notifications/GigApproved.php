<?php

namespace App\Notifications;

use App\Mail\GigApproved as MailGigApproved;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GigApproved extends Notification
{
    use Queueable;

    public $gig;

    /**
     * Create a new notification instance.
     */
    public function __construct($gig)
    {
        $this->gig = $gig;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailGigApproved
    {
        return (new MailGigApproved($this->gig));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => __('Your Gig has been approved'),
            'link' => route('gigs.show', ['gig' => $this->gig->id]),
        ];
    }
}
