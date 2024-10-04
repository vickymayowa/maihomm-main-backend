<?php

namespace App\Notifications;

use App\Mail\AppMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MessagingNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $data;
    protected $send_via;
    public function __construct(array $data, array $send_via)
    {
        $this->data = $data;
        $this->send_via = $send_via;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $methods = [];
        if (in_array("in_app", $this->send_via)) {
            $methods[] = "database";
        }
        if (in_array("email", $this->send_via)) {
            $methods[] = "mail";
        }
        return $methods;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new AppMailer([
            "data" => [
                "name" => $notifiable->names(),
                "data" => $this->data,
            ],
            "template" => "emails.general.messaging",
            "subject" => $this->data["title"],
        ]))->to($notifiable->email);
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


    public function toDatabase($notifiable)
    {
        return [
            "data" => $this->data["data"] ?? null,
            "title" => $this->data["title"] ?? null,
            "message" => $this->data["message"] ?? null,
            "link" => $this->data["link"] ?? null,
            "type" => $this->data["type"] ?? null,
            "batch_no" => $this->data["batch_no"] ?? null,
        ];
    }
}
