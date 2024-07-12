<?php

namespace App\Console\Commands;

use App\Models\Loan;
use App\Models\User;
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

        $users = User::whereHas('loans', function ($query) use ($dueDate) {
            $query->whereNull('returned_at')
                  ->whereDate('due_date', $dueDate);
        })->with(['loans' => function ($query) use ($dueDate) {
            $query->whereNull('returned_at')
                  ->whereDate('due_date', $dueDate)
                  ->with('book');
        }])->get();

        foreach ($users as $user){
            $user->notify(new BookReturnReminder($user->loans));
            $this->info("Reminder sent to User ID: {$user->id} for " . $user->loans->count() . " books.");
        }
        $this->info("Reminders sent to " . $users->count() . " users.");
    }
}
