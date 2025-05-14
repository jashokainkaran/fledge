<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ApplicationDecision extends Notification
{
    use Queueable;

    protected $application;

    /**
     * Create a new notification instance.
     */
    public function __construct(JobApplication $application)
    {
        $this->application = $application;
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
        $jobTitle = $this->application->job->title;
        $status = $this->application->status;

        $message = new MailMessage();
        $message->greeting("Hi {$notifiable->name},");

        if ($status === 'Accepted') {
            $message->subject("Your Application for \"$jobTitle\" Was Accepted")
                    ->line("Congratulations! Your application for the job \"$jobTitle\" has been accepted.")
                    ->line('The employer will reach out to you soon.');
        } elseif ($status === 'Rejected') {
            $message->subject("Your Application for \"$jobTitle\" Was Rejected")
                    ->line("We regret to inform you that your application for the job \"$jobTitle\" was not successful.")
                    ->line('Feel free to apply for other opportunities.');
        }

        return $message->line('Thank you for using Fledge!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'job_title' => $this->application->job->title,
            'status' => $this->application->status,
        ];
    }
}