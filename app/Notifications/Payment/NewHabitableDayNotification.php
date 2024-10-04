<?php

namespace App\Notifications\Payment;

use App\Models\HabitableDay;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewHabitableDayNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $day;
    public function __construct(HabitableDay $day)
    {
        $this->day = $day;
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->buildSubject())
            ->greeting("Hello " . $notifiable->first_name)
            ->lines($this->buildMessage())
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
                "status" => $this->day->status,
                "habitable_day_id" => $this->day->id
            ],
            "link" => null,
            "type" => "habitable_day",
            "batch_no" => null,
        ];
    }

    public function buildSubject()
    {
        $available_days = $this->day->available_days;
        return "Congratulations! You've Earned $available_days Habitable Days.";
    }

    public function buildMessage()
    {
        $available_days = $this->day->available_days;
        $code = $this->day->code;
        return [
            "We hope this message finds you well!",
            "We're delighted to share some fantastic news with you. You've earned an extra $available_days Habitable Days to use towards exclusive property booking discounts. Your dedication to our platform is truly appreciated, and we're thrilled to be a part of your journey in finding your ideal living space.",
            "Your code is: **$code**",
            "These additional days are a testament to your commitment, and we're excited to see you make the most of them. You can now enjoy even more flexibility and choice in selecting your perfect property.",
            "Don't hesitate to explore our listings and find the space that feels just right for you. Your dream home might be closer than you think!",
            "If you have any questions or need assistance with your booking, please feel free to reach out. We're here to ensure your experience is as seamless and enjoyable as possible.",
            "Thank you for choosing us as your trusted property partner. We look forward to helping you find your ideal living space."
        ];
    }
}
