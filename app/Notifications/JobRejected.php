<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Job;

class JobRejected extends Notification
{
    use Queueable;

    protected Job $job;

    /**
     * Create a new notification instance.
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your job listing was rejected')
            ->greeting("Hi {$notifiable->company_name},")
            ->line("Unfortunately, your job posting titled “{$this->job->title}” did not meet our approval criteria.")
            ->line('Please review the job and submit again with the required changes.')
            ->action('Review Job', url("/employer/jobs/{$this->job->id}/edit"))
            ->line('If you have any questions, feel free to contact support.');
    }

    /**
     * Get the array representation of the notification (optional).
     */
    public function toArray($notifiable): array
    {
        return [];
    }
}