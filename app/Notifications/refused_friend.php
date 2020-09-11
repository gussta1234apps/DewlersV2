<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class refused_friend extends Notification
{
    use Queueable;
    protected $infouser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $infouser)
    {
        $this->infouser= $infouser;
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $friend_no = new MailMessage;
        $friend_no->subject('Friend requested declined.')
            ->from('dewlermailtest@gmail.com', 'Dewlers')
            ->greeting('No new friends')
            ->line($this->infouser[0]. 'declined your friend request.');

        return ($friend_no);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
