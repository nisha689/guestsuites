<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        return (new MailMessage)
        ->line('You are receiving this email because we received a password reset request for your account.')
        /*->action(Lang::getFromJson('Reset Password'), url(config('app.url').route('admin.password.reset', $this->token, false)))*/
        ->action('Reset Password', url('admin_password/reset', $this->token))
        ->line(Lang::getFromJson('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.admin.expire')]))
        ->line('If you did not request a password reset, no further action is required.');

    }
    
}
