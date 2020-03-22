<?php

namespace ChemLab\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChanged extends Notification
{
    use Queueable;

    /**
     * IP address
     *
     * @var string
     */
    protected $ip;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $loc = geoip()->getLocation($this->ip)->toArray();

        if ($loc['default'] == true)
            $address = $loc['ip'];
        else
            $address = $loc['ip'] . " (" . $loc['city'] . ", " . $loc['country'] . ", " . $loc['iso_code'] . ")";

        return (new MailMessage)
            ->subject('ChemLab: your password changed')
            ->greeting("Dear {$notifiable->name}, ")
            ->line('You are receiving this email because password to your account has been changed.')
            ->line('The change has been done from following location: ' . $address . '.')
            ->line('If you did not change your password, please contact your ChemLab Administrator immediately. Otherwise, disregard this message.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
