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
        return Inertia::render('Wishlists/Index', ['wishlists' => $wishlists]);
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

        return redirect()->route('wishlists.index')->with('success', 'Book added to wishlist');
    }
    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();
        return redirect()->route('wishlist.index')->with('success', 'Book removed from wishlist.');

    }
}
