<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployerVerified extends Notification implements ShouldQueue
{
    use Queueable;

    protected $employer;

    /**
     * Create a new notification instance.
     */
    public function __construct($employer)
    {
        $this->employer = $employer;
    }

    /**
     * Get the notification’s delivery channels.
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
            ->subject('Your Employer Account Has Been Verified')
            ->greeting('Hello ' . $this->employer->name . ',')
            ->line('Congratulations! Your account is now verified.')
            ->action('Go to Dashboard', url('/employer/dashboard'))
            ->line('Thank you for using ' . config('app.name') . '!');
    }

    /**
     * Get the array representation of the notification (for database channel).
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Your employer account has been verified.',
            'employer_id' => $this->employer->id,
        ];
    }
}