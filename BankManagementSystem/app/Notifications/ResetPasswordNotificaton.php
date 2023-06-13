<?php

namespace App\Notifications;

use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotificaton extends Notification
{
    use Queueable;

    public $message;
    public $subject;
    public $fromEmail;
    public $malier;
    public $otp;
    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->message="you must verification your account ";
        $this->subject="subject";
        $this->fromEmail='hello@example.com';
        $this->malier='smtp';
        $this->otp=new Otp;
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
        $otp=$this->otp->generate($notifiable->email,6,60);

        return (new MailMessage)
            ->mailer('smtp')
            ->subject($this->subject)
            ->greeting('hello'.$notifiable->first_name)
            ->line($this->message)
            ->line('Code'.$otp->token);
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
