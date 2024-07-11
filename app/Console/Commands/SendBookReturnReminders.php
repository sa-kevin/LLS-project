<?php

namespace App\Console\Commands;

use App\Models\Loan;
use App\Notifications\BookReturnReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendBookReturnReminders extends Command
{
    
    protected $signature = 'loans:send-reminders';
    protected $description = 'Send reminders for books due soon.';

    public function handle()
    {
        $dueDate = Carbon::tomorrow();

        $loans = Loan::with('user', 'book')
            ->whereNull('returned_at')
            ->whereDate('due_date', $dueDate)
            ->get();

        foreach ($loans as $loan){
            $loan->user->notify(new BookReturnReminder($loan));
            $this->info("Reminder sent for loan ID: {$loan->id}");
        }
        $this->info("Reminders sent for {$loans->count()} loans.");
    }
}
