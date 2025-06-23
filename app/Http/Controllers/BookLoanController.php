<?php

namespace App\Http\Controllers;

use App\Models\BookLoan;
use App\Models\LibraryBook;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookLoanController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $query = BookLoan::with(['book', 'borrower'])
            ->where('school_id', $schoolId);

        if ($request->filled('search')) {
            $query->whereHas('borrower', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $loans = $query->latest()->paginate(10);
        return view('in.school.book_loans.index', compact('loans'));
    }

    public function create()
    {
        $schoolId = Auth::user()->school_id;
        $books = LibraryBook::where('school_id', $schoolId)->where('available_quantity', '>', 0)->get();
        $users = User::where('school_id', $schoolId)->get();

        return view('in.school.book_loans.create', compact('books', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:library_books,id',
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
        ]);

        $book = LibraryBook::findOrFail($request->book_id);
        if ($book->available_quantity < 1) {
            return back()->withErrors(['book_id' => 'No available copies.']);
        }

        BookLoan::create([
            'school_id' => Auth::user()->school_id,
            'book_id' => $request->book_id,
            'user_id' => $request->user_id,
            'loan_date' => $request->loan_date,
            'due_date' => $request->due_date,
            'status' => 'issued',
        ]);

        // Decrease available quantity
        $book->decrement('available_quantity');

        return redirect()->route('book_loans.index')->with('success', 'Loan issued.');
    }

    public function return(BookLoan $book_loan)
    {
        $this->authorizeLoan($book_loan);

        $book_loan->update([
            'return_date' => now(),
            'status' => 'returned',
        ]);

        $book_loan->book->increment('available_quantity');

        return back()->with('success', 'Book marked as returned.');
    }

    public function destroy(BookLoan $book_loan)
    {
        $this->authorizeLoan($book_loan);
        $book_loan->delete();
        return back()->with('success', 'Loan deleted.');
    }

    private function authorizeLoan(BookLoan $loan)
    {
        if ($loan->school_id !== Auth::user()->school_id) {
            abort(403);
        }
    }
}

