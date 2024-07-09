<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
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
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'due_date' => 'required|date|after_or_equal:loaned_at',
        ]);

        $book = Book::findOrFail($request->book_id);

        if (!$book->isAvailable()) {
            return back()->with('error', 'This book is currently not available.');
        }

        $loan = Loan::create([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
            'loaned_at' => now(),
            'due_date' => $request->due_date,
        ]);

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
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'loaned_at' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loaned_at',
            'returned_at' => 'nullable|date|after_or_equal:loaned_at',
        ]);

        $loan->update($request->all());

        return redirect()->route('loans.index')->with('success', 'Loan updated successfully');
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully');
    }
}
