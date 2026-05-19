<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AccountRegistered extends Notification
{
    use Queueable;

    /**
     * The channels the notification should be delivered on.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $appName = config('app.name');

        return (new MailMessage)
            ->subject("You have been registered on {$appName}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Thank you for registering as an advertiser on {$appName}.")
            ->line('Your account has been created successfully and is currently awaiting admin approval.')
            ->line('You will be able to sign in once an administrator has approved your account.')
            ->line('Thank you for choosing us!');
    }
}
