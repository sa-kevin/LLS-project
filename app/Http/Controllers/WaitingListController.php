<?php

namespace App\Http\Controllers;

use App\Models\WaitingList;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WaitingListController extends Controller
{
    public function index()
    {
        $waitingLists = WaitingList::with('book')->where('user_id', auth()->id())->get();
        return Inertia::render('WaitingLists/Index', ['waitignlist' => $waitingLists]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);
        try {
            WaitingList::create([
                'user_id' => auth()->id(),
                'book_id' => $request->book_id,
            ]);
    
            return back()->with('success', 'You have been added to the waiting list.');
        } catch (QueryException $e) {
            // Check if the exception is due to a duplicate entry
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'You are already on the waiting list for this book.');
            }
            
            // For other database errors
            return back()->with('error', 'An error occurred. Please try again.');
        }
    }
    public function destroy(WaitingList $waitingList)
    {
        $waitingList->delete();
        return redirect()->route('waitinglists.index')->with('success', ' You have been removed from the waiting list for this book.');
    }
}
