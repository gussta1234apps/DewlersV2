<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class witness_decline extends Notification
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
        //
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
        switch ($this->infouser[1]) {

            case 1: // challenger
                $witness_no = new MailMessage;
                $witness_no->subject('Decline Dewl')
                    ->from('dewlermailtest@gmail.com', 'Dewlers')
                    ->greeting('On the next')
                    ->line($this->infouser[2].' declined to serve as a witness for the Dewl '.$this->infouser[0].'. Continue the Dewl without a Witness.');

                return ($witness_no);

                break;

        }
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
