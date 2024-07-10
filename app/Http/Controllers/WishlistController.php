<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WishlistController extends Controller
{
    public function index()
    {
        
        $wishlists = Wishlist::with('book')->where('user_id', auth()->id())->get();
        return Inertia::render('wishlists', ['wishlists' => $wishlists]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $user = auth()->user();
        $bookId = $request->book_id;

        $existingWishlistItem = Wishlist::where('user_id', $user->id)
            ->where('book_id', $request->book_id)
            ->first();

        if ($existingWishlistItem) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'This book is already in your wishlist.',
                'book_id' => $bookId,
            ]);
        }

        Wishlist::create([
            'user_id' => $user->id,
            'book_id' => $request->book_id,
        ]);

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'book added wishlist.',
            'book_id' => $bookId,
        ]);
    }
    
    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();
        $updatedWishlist = Wishlist::with('book')->where('user_id', auth()->id())->get();

        return Inertia::render('Dashboard', [
            'wishlist' => $updatedWishlist,
            'flash' => [
                'success' => 'Book removed from wishlist.'
            ]
            ]);
    }

    // not using it yet
    public function toggle(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('book_id', $request->book_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Book removed from wishlist';
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'book_id' => $request->book_id,
            ]);
            $message = 'Book added to wishlist';
        }

        return redirect()->route('wishlists')->with('success', $message);
    }
}
