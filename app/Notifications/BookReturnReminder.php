<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class BookReturnReminder extends Notification
{
    use Queueable;
    protected $loans;

    public function __construct(Collection $loans)
    {
        $this->loans = $loans;
    }

    
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('Reminder: Book Due for Return')
            ->line('This is a friendly reminder that the books you borrowed is due for return tomorrow.');
        
        foreach ($this->loans as $loan) {
            $mailMessage->line("- {$loan->book->title}");
        }

        return $mailMessage
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
