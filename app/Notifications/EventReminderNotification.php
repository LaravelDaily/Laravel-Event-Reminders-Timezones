<?php

namespace App\Notifications;

use App\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventReminderNotification extends Notification
{
    use Queueable;

    private $event;

    /**
     * Create a new notification instance.
     *
     * @param $event
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Event Reminder')
                    ->line('An event is scheduled for you in less than an hour')
                    ->line('Title: ' . $this->event->title)
                    ->line('Description: ' . $this->event->description)
                    ->line('Start Time: ' . $this->event->start_time . ' (' . $this->event->timezone . ')');
    }
}
