<?php

namespace App\Notifications;

// app/Notifications/JobApproved.php


use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Job;

class JobApproved extends Notification
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
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your job listing was approved!')
            ->greeting("Hi {$notifiable->company_name},")
            ->line("Your job “{$this->job->title}” has been approved and is now live.")
            ->action('View Job', url("/jobs/{$this->job->id}"))
            ->line('Thanks for using Fledge!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'job_id'    => $this->job->id,
            'job_title' => $this->job->title,
        ];
    }
}