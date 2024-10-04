<?php

namespace App\Notifications\Payment;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use App\Constants\AppConstants;
use App\Constants\StatusConstants;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StatusNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $payment;
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // return ['mail', 'database'];
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(AppConstants::SUDO_EMAIL, 'Maihomm')
            ->subject($this->buildSubject())
            ->greeting("Hello " . $notifiable->first_name)
            ->line($this->buildMessage())
            ->line("View more details in porfolio.")
            ->action('Login', route("login"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable)
    {
        return [
            "title" => $this->buildSubject(),
            "message" => $this->buildMessage(),
            "data" => [
                "status" => $this->payment->status,
                "payment_id" => $this->payment->id
            ],
            "link" => null,
            "type" => "payment",
            "batch_no" => null,
        ];
    }

    public function buildSubject()
    {
        $status = $this->payment->status;
        if($status == StatusConstants::PENDING){
            return "Payment Awaiting Verification.";
        }
        if($status == StatusConstants::COMPLETED){
            return "Payment Approved.";
        }
        if($status == StatusConstants::DECLINED){
            return "Payment Declined.";
        }
    }

    public function buildMessage()
    {
        $status = $this->payment->status;
        if($status == StatusConstants::PENDING){
            return "Your payment has been submitted and will be reviewed shortly.";
        }
        if($status == StatusConstants::COMPLETED){
            return "Your payment has been approved.";
        }
        if($status == StatusConstants::DECLINED){
            return "Your payment has been declined.";
        }
    }
}
