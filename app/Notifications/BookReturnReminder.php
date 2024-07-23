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
            ->subject(__('email.book_due.subject'))
            ->line(__('email.book_due.line1'));
        
        foreach ($this->loans as $loan) {
            $mailMessage->line("- {$loan->book->title}");
        }

        return $mailMessage
                ->action(__('email.book_due.action'), url('/dashboard'))
                ->line(__('email.book_due.footer'));

        
    }
}
