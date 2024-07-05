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
        Wishlist::create([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
        ]);

        return redirect()->route('wishlists')->with('success', 'Book added to wishlist');
    }
    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();
        return redirect()->route('wishlists')->with('success', 'Book removed from wishlist.');

    }

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
