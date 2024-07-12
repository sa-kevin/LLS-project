<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\Loan;
use App\Models\WaitingList;
use App\Notifications\BookAvailableNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendBookAvailableNotifications extends Command
{

    protected $signature = 'books:notify-available';

    protected $description = 'Notify users about available books they were waiting for';

    public function handle()
    {
        DB::beginTransaction();

        try {
            $availableBooks = Book::whereHas('waitingList')
                                  ->with('waitingList.user')
                                  ->get();

            foreach ($availableBooks as $book) {
                $isAvailable = !Loan::where('book_id', $book->id)
                                    ->whereNull('returned_at')
                                    ->exists();
                
                if ($isAvailable) {
                    $nextInLine = $book->waitingList->sortBy('created_at')->first();
                    
                    if ($nextInLine) {
                        // Send notification
                        $nextInLine->user->notify(new BookAvailableNotification($book));

                        // Remove user from waiting list
                        $nextInLine->delete();

                        $this->info("Notification sent and user removed from waiting list for book: {$book->title}, user: {$nextInLine->user->name}");
                    }
                }
            } 

            DB::commit();
            $this->info('Book availability notifications sent and waiting lists updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}
