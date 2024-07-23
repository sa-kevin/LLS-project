<?php

namespace App\Notifications;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookAvailableNotification extends Notification
{
    use Queueable;

    protected $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject(__('email.available.subject') . $this->book->title)
                    ->line(__('email.available.line1'))
                    ->line(__('email.available.line1.5') . $this->book->title . ' by ' . $this->book->author)
                    ->action(__('email.available.action'), url('/books' . $this->book->id))
                    ->line(__('email.available.line2'))
                    ->line(__('email.available.footer'));
    }
}
