<?php

namespace App\Notifications\Withdraw;

use Illuminate\Bus\Queueable;
use App\Constants\AppConstants;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WithdrawNotification extends Notification
{
    use Queueable;
    private $data;
    private $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($data, $user)
    {
        //
        $this->data = $data;
        $this->user = $user;
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
                    ->from(AppConstants::SUDO_EMAIL, 'Maihomm')
                    ->subject('New Withdrawal Request')
                    ->greeting("Hello,")
                    ->line("Name: ".$this->user['last_name']. " " . $this->user['first_name'])
                    ->line("Email: ".$this->user['email'])
                    ->line("Amount: ".$this->data['amount']);
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
