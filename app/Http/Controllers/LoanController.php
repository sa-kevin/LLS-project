<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('book', 'user')->get();
        return Inertia::render('Loans/Index', ['loans' => $loans]);
    }

    public function create()
    {
        $books = Book::all();
        $users = User::all();
        return Inertia::render('Loans/Create', [
            'books' => $books,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Raw request data: ' . json_encode($request->all()));
        Log::info('Received due_date: ' . $request->due_date);

        Log::info('Server timezone: ' . config('app.timezone'));
        Log::info('Current server time: ' . now());

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $book = Book::findOrFail($request->book_id);

        if (!$book->isAvailable()) {
            return back()->with('error', 'This book is currently not available.');
        }

        $dueDate = Carbon::parse($request->due_date, config('app.timezone'));
        Log::info('Parsed due_date: ' . $dueDate->toDateTimeString());

        $loan = Loan::create([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
            'loaned_at' => now(),
            'due_date' => $dueDate,
        ]);
        Log::info('Saved due_date: ' . $loan->due_date);

        return back()->with('success', 'Book rented successfully.');
    }

    public function show(Loan $loan)
    {
        return Inertia::render('Loans/Show', [
            'loan' => $loan
        ]);
    }

    public function edit(Loan $loan)
    {
        $books = Book::all();
        $users = User::all();
        return Inertia::render('Loans/Edit', [
            'loan' => $loan,
            'books' => $books,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
{
    Log::info('Update - Raw request data: ' . json_encode($request->all()));

    $request->validate([
        'book_id' => 'required|exists:books,id',
        'user_id' => 'required|exists:users,id',
        'loaned_at' => 'required|date',
        'due_date' => 'required|date|after_or_equal:loaned_at',
        'returned_at' => 'nullable|date|after_or_equal:loaned_at',
    ]);

    $loanedAt = Carbon::parse($request->loaned_at)
                      ->setTimezone(config('app.timezone'))
                      ->startOfDay();

    $dueDate = Carbon::parse($request->due_date)
                     ->setTimezone(config('app.timezone'))
                     ->endOfDay();

    $returnedAt = $request->returned_at
        ? Carbon::parse($request->returned_at)
                ->setTimezone(config('app.timezone'))
                ->endOfDay()
        : null;

    Log::info('Update - Parsed loaned_at: ' . $loanedAt->toDateTimeString());
    Log::info('Update - Parsed due_date: ' . $dueDate->toDateTimeString());
    Log::info('Update - Parsed returned_at: ' . ($returnedAt ? $returnedAt->toDateTimeString() : 'null'));

    $loan->update([
        'book_id' => $request->book_id,
        'user_id' => $request->user_id,
        'loaned_at' => $loanedAt,
        'due_date' => $dueDate,
        'returned_at' => $returnedAt,
    ]);

    Log::info('Update - Saved loan data: ' . json_encode($loan->toArray()));

    return back()->with('success', 'Loan updated successfully');
}

    public function destroy(Loan $loan)
    {
        $loan->delete();

        return back()->with('success', 'Loan deleted successfully');
    }

    public function userLoans(Request $request)
    {
        $user = $request->user();
        $loans = Loan::with('book')
        ->where('user_id', $user->id)
        ->whereNull('returned_at')
        ->orderBy('due_date')
        ->get();

        return Inertia::render('Dashboard', ['loans' => $loans,]);
    }

    public function returnBook(Request $request, Loan $loan)
    {
        $loan->returned_at = Carbon::now();
        $loan->save();

        return back()->with('success', 'Book returned succesfully');
    }
}
