<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookReturnReminder extends Notification
{
    use Queueable;
    protected $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Reminder: Book Due for Return')
                    ->line('This is a friendly reminder that the book you borrowed is due for return.')
                    ->line('Book: ' . $this->loan->book->title)
                    ->line('Due Date: ' . $this->loan->due_date->format('F j, Y'))
                    ->action('View My Loans', url('/dashboard'))
                    ->line('Thank you for using Tech Book!');
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
