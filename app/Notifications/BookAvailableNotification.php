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
                    ->subject('Book Now Available: ' . $this->book->title)
                    ->line('A book your were waiting for is now available.')
                    ->line('Book:' . $this->book->title . ' by ' . $this->book->author)
                    ->action('Rent Now', url('/books' . $this->book->id))
                    ->line('Please Note that this book will be held for you for the next 24 hours.')
                    ->line('Thank you for using Tech Book');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
