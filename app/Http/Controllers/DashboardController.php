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
        $totalLoans = Loan::where('user_id', $user->id)->count();
        $loans = Loan::with('book')
            ->where('user_id', $user->id)
            ->orderByRaw('ISNULL(returned_at) DESC, returned_at ASC, due_date ASC')
            ->get();
        
        $latestLoan = Loan::where('user_id', $user->id)
            ->with('book')
            ->latest('loaned_at')
            ->first();
        
        $latestBookTitle = $latestLoan ? $latestLoan->book->title : 'No books loaned yet';

        return Inertia::render('Dashboard', [
            'wishlist' => $wishlist,
            'loans' => $loans,
            'totalLoans' => $totalLoans,
            'latestBookTitle' => $latestBookTitle,
            'flash' => session('flash', [],)
        ]);
    }
}
