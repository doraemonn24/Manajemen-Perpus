<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class PegawaiBookController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('judul')->paginate(10);
        return view('pegawai.books.index', compact('books'))
            ->with('pageHeader', 'Manajemen Buku');
    }

    public function create()
    {
        return view('pegawai.books.create')
            ->with('pageHeader', 'Tambah Buku');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'maksimal_waktu_peminjaman' => 'required|integer|min:1',
            'denda_per_hari' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        Book::create($validated);

        return redirect()->route('pegawai.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        return view('pegawai.books.edit', compact('book'))
            ->with('pageHeader', 'Edit Buku');
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'maksimal_waktu_peminjaman' => 'required|integer|min:1',
            'denda_per_hari' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        $book->update($validated);

        return redirect()->route('pegawai.books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();
        return redirect()->route('pegawai.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}