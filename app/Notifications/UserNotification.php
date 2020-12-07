<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification implements ShouldQueue
{

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $detailsTransfer;

    public function __construct($detailsTransfer)
    {
        $this->detailsTransfer = $detailsTransfer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {    
        
        return (new MailMessage)
                        ->line('você recebeu uma transferência de R$ '.$this->detailsTransfer['value'])
                        ->line('Thank you for using our application!');
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
            'data' => $this->detailsTransfer,
        ];
    }

}
