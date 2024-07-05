<?php

namespace App\Http\Controllers;

use App\Models\WaitingList;
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
        WaitingList::create([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
        ]);
        return redirect()->route('waitinglists.index')->with('success', 'you have been added to the waiting list for this book.');
    }
    public function destroy(WaitingList $waitingList)
    {
        $waitingList->delete();
        return redirect()->route('waitinglists.index')->with('success', ' You have been removed from the waiting list for this book.');
    }
}
