<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
   
    public function index()
    {
        $query = Book::query();
        $books = $query->paginate(10);
        return Inertia::render('Books', ['books' => $books->items()]);
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
        return Inertia::render('Books/Show', ['book' => $book]);
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
