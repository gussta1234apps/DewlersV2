<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusUpdate extends Notification
{
    use Queueable;
    protected $infouser;
//    var challenged;




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

        switch ($this->infouser[1]){

            case 0: // challenger
                $challenger = new MailMessage;
                $challenger->subject('Get ready to Dewl!')
                    ->from('dewlermailtest@gmail.com', 'Dewlers')
                    ->greeting('Do you accept it?')
                    ->line($this->infouser[0].' has created the Dewl '.$this->infouser[3].'.  Do you accept it?')
                    ->action('Check it out', url('/dashboard'));
                return ($challenger);

                break;

            case 1: //witness

                $witness = new MailMessage;
                $witness->subject(' A Dewl needs your help')
                    ->from('dewlermailtest@gmail.com', 'Dewlers')
                    ->greeting('Always be fair!')
                    ->line('You have been invited by '.$this->infouser[0].' to participate on the Dewl '.$this->infouser[3].' as a witness.')
                    ->action('Let’s Dewl!', url('/dashboard'));
                return ($witness);


                break;

            case 2: //winner

                $winner = new MailMessage;
                $winner->subject('You are the winner!')
                    ->from('dewlermailtest@gmail.com', 'Dewlers')
                    ->greeting('Congratulations!')
                    ->line('You are the winner of the Dewl '.$this->infouser[0].'! The stacks you won are already on your account.') // infouser[0] debe ser el nombre del dewl
                    ->action('My Account', url('/dashboard'));
//                    ->line('Continue Dewling!');

//                    ->action('Check it out', url('/dashboard'));
                return ($winner);


                break;

            case 3: //loser

                $loser = new MailMessage;
                $loser->subject('You lost the Dewl')
                    ->from('dewlermailtest@gmail.com', 'Dewlers')
                    ->greeting('Better luck next time!')
                    ->line('You have lost against '.$this->infouser[3].' the Dewl '.$this->infouser[0].".")  // infouser[0] debe ser el nombre del dewl, infouser[3] debe ser el nombre del oponente
                    ->action('My Account', url('/dashboard'));
//                    ->line('Continue Dewling!');
                return ($loser);

                break;

            case 4: //double or nothing

                $double_or_noting=new MailMessage;
                $double_or_noting->subject('Continue the Dewl!')
                    ->from('dewlermailtest@gmail.com', 'Dewlers')
                    ->greeting('Lets Dewl!')
                    ->line('You have been invited by '.$this->infouser[0].' to continue Dewling in a Double or Nothing.')
                    ->action('Check Dewl', url('/dashboard'));
                return ($double_or_noting);
                break;

            case 5: //witness accept

                //infouser[0] nombre del dewl
                //infouser[1] bandera de la operacion
                //infouser[2] nombre del creador del duelo
                //infouser[3] nombre del withness

                $double_or_noting=new MailMessage;
                $double_or_noting->subject('The witness acepted the Dewl')
                    ->from('dewlermailtest@gmail.com', 'Dewlers')
                    ->greeting('Lets Dewl!')
                    ->line('Your witness '.$this->infouser[3].' agreed to participate.')
                    ->action('Check Dewl', url('/dashboard'));
                return ($double_or_noting);
                break;

            case 6: //witness refuse

                //infouser[0] nombre del dewl
                //infouser[1] bandera de la operacion
                //infouser[2] nombre del witness

                $double_or_noting=new MailMessage;
                $double_or_noting->subject('Witness declined.')
                    ->from('dewlermailtest@gmail.com', 'Dewlers')
                    ->greeting('Witness declined.')
                    ->line($this->infouser[3].' declined to serve as a witness for the Dewl '.$this->infouser[0].'. Continue the Dewl without a Witness.')
                    ->action('Check Dewl', url('/dashboard'));
                return ($double_or_noting);
                break;
        }

//        if ($this->infouser[1]==0){
//            $challenger = new MailMessage;
//        $challenger->subject('New Dewl')
//            ->from('dewlermailtest@gmail.com', 'Dewlers')
//            ->greeting('Lets Dewl!')
//            ->line('You have been invited by '.$this->infouser[0].' to participate  on a Dewl')
//            ->action('Check it out', url('/status'))
//            ->line('Good luck do the best!');
//        return ($challenger);
//    }
//        else{
//            $witness = new MailMessage;
//            $witness->subject('New Dewl')
//                ->from('dewlermailtest@gmail.com', 'Dewlers')
//                ->greeting('Lets Dewl!')
//                ->line('You have been invited by '.$this->infouser[0].' to participate on a Dewl as a witness')
//                ->action('Check it out', url('/witness'))
//                ->line('Good luck!');
//            return ($witness);
//        }




//        $witness=new MailMessage;
//        $witness->subject('New Dewl')
//            ->from('dewlermailtest@gmail.com', 'Dewlers')
//            ->greeting('Lets Dewl!')
//            ->line('You has been invited for '.$this->infouser[0].' to be participed on a dewl')
//            ->action('Check it out', url('/status'))
//            ->line('Good luck do the best!');


    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable spell action great nice job great
     * @return array create acount? of course
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
