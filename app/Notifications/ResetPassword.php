<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends ResetPasswordNotification
{
    public $otp;

    public function __construct($token, $otp = null)
    {
        parent::__construct($token);
        $this->otp = $otp;
    }

    public function toMail($notifiable)
    {
        // Change this to point to the OTP verification page instead
        $url = url(route('password.verify-otp.form', [
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $message = (new MailMessage)
            ->subject('🐾 Reset Your Cat Adoption Password')
            ->greeting('Jumuad, Jamaica 🐱')
            ->line('Naka receive ka ani nga email kay nakadawat mi ug password reset request para sa imong account.');
                             
        // Add OTP option if provided
        if ($this->otp) {
            $message->line('**Your 6-digit verification code is: ' . $this->otp . '**')
                    ->line('This code will expire in 10 minutes.')
                    ->line('---')
                    ->line('Click the button below to enter your code:');
        }

        $message->action('Enter Verification Code', $url)
                ->line('If you did not request a password reset, no further action is required.')
                 ->salutation('Regards, Cat Adoption System 🐾');

        return $message;
    }
}