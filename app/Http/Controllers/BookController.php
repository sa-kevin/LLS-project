<?php

namespace App\Http\Controllers;

use App\Helpers\StorageHelper;
use App\Models\Book;
use App\Services\OpenDBService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;


class BookController extends Controller
{
    protected $openDBService;

    public function __construct(OpenDBService $openDBService)
    {
        $this->openDBService = $openDBService;
    }


   public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $booksQuery = Book::query()
        ->when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                         ->orWhere('author', 'like', "%{$search}%")
                         ->orWhere('isbn', 'like', "%{$search}%");
        })
        ->with(['loans', 'waitingList']);

        $total = $booksQuery->count();

        $books = $booksQuery->forPage($page, $perPage)->get()
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
                'cover_image' => $book->cover_image 
                ? StorageHelper::getMinioUrl($book->cover_image)
                : null,
            ];
        });

        $paginatedBooks = new LengthAwarePaginator(
            $books,
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return Inertia::render('Books', [
            'books' => $paginatedBooks,
            'search' => $search,
            'perPage' => $perPage,
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
        $bookData = $request->all();
        
        // fetch & store cover image
        if (!empty($bookData['isbn'])) {
            $coverUrl = $this->openDBService->getCoverImage($bookData['isbn']);
            if ($coverUrl) {
                $coverPath = $this->openDBService->downloadAndStoreImage($coverUrl, $bookData['isbn']);
                $bookData['cover_image'] = $coverPath;
            }
        }
        
        Book::create($bookData);
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
