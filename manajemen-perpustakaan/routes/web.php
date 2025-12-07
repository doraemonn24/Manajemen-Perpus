<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Pegawai\PegawaiDashboardController;
use App\Http\Controllers\Pegawai\PegawaiBookController; 
use App\Http\Controllers\Pegawai\PegawaiLoanController;
use App\Http\Controllers\Mahasiswa\MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\MahasiswaLoanController;
use App\Http\Controllers\Mahasiswa\MahasiswaBookController;
use App\Http\Controllers\Mahasiswa\MahasiswaNotificationController;
use App\Http\Controllers\Mahasiswa\ReviewController;
use App\Http\Controllers\PublicBookController;

use Illuminate\Support\Facades\Route;


Route::get('/', [PublicBookController::class, 'home'])->name('home');
Route::get('/katalog', [PublicBookController::class, 'catalog'])->name('books.index');
Route::get('/buku/{id}', [PublicBookController::class, 'show'])->name('books.show');
Route::get('/about', function () {
    return redirect('/'); 
})->name('about');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('books', AdminBookController::class);
    Route::get('transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::put('transactions/{loan}/return', [AdminTransactionController::class, 'returnBook'])->name('transactions.return');
});
Route::middleware(['auth', 'role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');
    Route::resource('books', PegawaiBookController::class);
    Route::resource('loans', PegawaiLoanController::class);
    Route::post('/loans/{loan}/return', [PegawaiLoanController::class, 'processReturn'])->name('loans.processReturn');
    Route::post('/loans/{loan}/fine-paid', [PegawaiLoanController::class, 'markFinePaid'])->name('loans.markFinePaid');
});
Route::middleware(['auth','role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('books', [MahasiswaBookController::class, 'index'])->name('books.index');
    Route::get('books/{book}', [MahasiswaBookController::class, 'show'])->name('books.show');
    Route::post('books/{book}/borrow', [MahasiswaBookController::class, 'borrow'])->name('books.borrow');
    Route::get('loans/{loan}/renew', [MahasiswaLoanController::class, 'showRenewForm'])->name('loans.renew.form');
    Route::post('loans/{loan}/renew', [MahasiswaLoanController::class, 'renew'])->name('loans.renew');
    Route::post('loans/{loan}/return', [MahasiswaLoanController::class, 'return'])->name('loans.return');
    Route::get('loans/{loan}/review', [ReviewController::class, 'create'])->name('loans.review');
    Route::post('loans/{loan}/review', [ReviewController::class, 'store'])->name('loans.review.store');
    Route::get('loans', [MahasiswaLoanController::class, 'index'])->name('loans.index');
    Route::get('loans/{loan}', [MahasiswaLoanController::class, 'show'])->name('loans.show');
    Route::get('notifications', [MahasiswaNotificationController::class, 'index'])->name('notifications.index');
});

require __DIR__.'/auth.php';