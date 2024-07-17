<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;


class BookController extends Controller
{
   public function index(Request $request)
    {
        $search = $request->input('search');

        $books = Book::query()
        ->when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                         ->orWhere('author', 'like', "%{$search}%")
                         ->orWhere('isbn', 'like', "%{$search}%");
        })
        ->with(['loans', 'waitingList'])
        ->get()
        ->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'description' => $book->description,
                'isbn' => $book->isbn,
                'published_at' => $book->published_at,
                'is_available' => $book->isAvailable(),
                'loans' => $book->loans,
                'waiting_list_count' => $book->waitingList->count(),
            ];
        });

        return Inertia::render('Books', [
        'books' => $books,
        'search' => $search,
    ]);
    }
  
    public function create()
    {
        return Inertia::render('Books/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:books',
            'published_at' => 'nullable|date',
            'description' => 'nullable|string',
        ]);
        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function show(Book $book)
    {
        return Inertia::render('Books', ['book' => $book]);
    }

    public function edit(Book $book)
    {
        return Inertia::render('Books/Edit', ['book' => $book]);
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:books,isbn' . $book->id,
            'published_at' => 'nullable|date',
            'description' => 'nullable|string',
        ]);
        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully');
    }

}
