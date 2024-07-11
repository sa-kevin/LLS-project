<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $wishlist = Wishlist::with('book')->where('user_id', $user->id)->get();
        $loans = Loan::with('book')
            ->where('user_id', $user->id)
            ->orderByRaw('ISNULL(returned_at) DESC, returned_at ASC, due_date ASC')
            ->get();

        return Inertia::render('Dashboard', [
            'wishlist' => $wishlist,
            'loans' => $loans,
            'flash' => session('flash', [],)
        ]);
    }
}
