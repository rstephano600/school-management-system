<?php

namespace App\Http\Controllers;

use App\Models\LibraryBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryBookController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $query = LibraryBook::where('school_id', $schoolId);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $books = $query->orderBy('title')->paginate(10);

        return view('in.school.library_books.index', compact('books'));
    }

    public function create()
    {
        return view('in.school.library_books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:0',
        ]);

        LibraryBook::create([
            ...$request->only([
                'isbn', 'title', 'author', 'publisher', 'edition', 'year_published',
                'category', 'price', 'quantity', 'available_quantity', 'rack_number', 'status'
            ]),
            'school_id' => Auth::user()->school_id,
        ]);

        return redirect()->route('library_books.index')->with('success', 'Book added.');
    }

    public function show(LibraryBook $library_book)
    {
        $this->authorizeSchool($library_book);
        return view('in.school.library_books.show', compact('library_book'));
    }

    public function edit(LibraryBook $library_book)
    {
        $this->authorizeSchool($library_book);
        return view('in.school.library_books.edit', compact('library_book'));
    }

    public function update(Request $request, LibraryBook $library_book)
    {
        $this->authorizeSchool($library_book);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:0',
        ]);

        $library_book->update($request->only([
            'isbn', 'title', 'author', 'publisher', 'edition', 'year_published',
            'category', 'price', 'quantity', 'available_quantity', 'rack_number', 'status'
        ]));

        return redirect()->route('library_books.index')->with('success', 'Book updated.');
    }

    public function destroy(LibraryBook $library_book)
    {
        $this->authorizeSchool($library_book);
        $library_book->delete();
        return back()->with('success', 'Book deleted.');
    }

    private function authorizeSchool($book)
    {
        if ($book->school_id !== Auth::user()->school_id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
