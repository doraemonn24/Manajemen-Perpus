<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PublicBookController extends Controller
{
    // 1. HOMEPAGE
    public function home()
    {
        $newBooks = Book::latest()->take(4)->get();
        $popularBooks = Book::orderBy('rating', 'desc')->take(4)->get();

        return view('welcome', compact('newBooks', 'popularBooks'));
    }

    public function catalog(Request $request)
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'terbaru':
                    $query->latest();
                    break;
                case 'terlama':
                    $query->oldest();
                    break;
                case 'rating_tertinggi':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'tahun_terbaru':
                    $query->orderBy('tahun_terbit', 'desc');
                    break;
            }
        } else {
            // Default sort
            $query->latest();
        }

        $categories = Book::select('kategori')->distinct()->pluck('kategori');
        $books = $query->paginate(12)->withQueryString();

        return view('books.index', compact('books', 'categories'));
    }

    public function show($id)
    {
        $book = Book::with('reviews.user')->findOrFail($id);
        $relatedBooks = Book::where('kategori', $book->kategori)->where('id', '!=', $id)->take(4)->get();

        return view('books.show', compact('book', 'relatedBooks'));
    }
}