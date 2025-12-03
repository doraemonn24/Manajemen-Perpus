<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class HomeController extends Controller
{
    public function index()
    {

        $newBooks = Book::orderBy('created_at', 'desc')
                        ->take(4) 
                        ->get();

        $popularBooks = Book::orderBy('rating', 'desc')
                            ->take(4)
                            ->get();

        return view('welcome', compact('newBooks', 'popularBooks'));
    }
}
