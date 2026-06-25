<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Illuminate\Http\Request $request) {
    $totalBooks = \App\Models\Book::sum('available_copies');
    $totalStudents = \App\Models\User::count(); // Assuming all users are students for now
    
    $user = clone $request->user();
    $user->load(['transactions.book', 'reservations.book', 'transactions.penalty']);
    
    return view('user.overviewPage', compact('totalBooks', 'totalStudents', 'user'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/notifications', function () {
    return view('user.notificationsPage');
})->middleware(['auth', 'verified'])->name('notifications');

use App\Http\Controllers\Member\CatalogController;
use App\Http\Controllers\Member\BorrowController;
use App\Http\Controllers\Member\ReservationController;

Route::get('/library', [CatalogController::class, 'index'])->middleware(['auth', 'verified'])->name('library');
Route::get('/library/{book}', [CatalogController::class, 'show'])->middleware(['auth', 'verified'])->name('library.show');
Route::get('/library/{book}/details', [CatalogController::class, 'details'])->middleware(['auth', 'verified'])->name('library.details');

Route::get('/borrowed', [BorrowController::class, 'index'])->middleware(['auth', 'verified'])->name('borrowed');

use App\Http\Controllers\Member\PenaltyController;

Route::get('/reservations', [ReservationController::class, 'index'])->middleware(['auth', 'verified'])->name('reservations');
Route::get('/penalties', [PenaltyController::class, 'index'])->middleware(['auth', 'verified'])->name('penalties');

Route::post('/library/{book}/borrow', [BorrowController::class, 'store'])->middleware(['auth', 'verified'])->name('library.borrow');
Route::post('/library/{book}/reserve', [ReservationController::class, 'store'])->middleware(['auth', 'verified'])->name('library.reserve');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/catalog', [BookController::class, 'index'])->name('admin.bookCatalog');
    Route::get('/add-book', [BookController::class, 'create'])->name('admin.addBook');
    Route::post('/add-book', [BookController::class, 'store'])->name('admin.bookCatalog.store');
    
    Route::get('/edit-book/{id}', [BookController::class, 'edit'])->name('admin.editBook');
    Route::put('/edit-book/{id}', [BookController::class, 'update'])->name('admin.updateBook');

    Route::delete('/catalog/{id}', [BookController::class, 'destroy'])->name('admin.bookCatalog.destroy');

    Route::get('/categories', function () {return view('admin.categoriesPage');})->name('admin.bookCategories');
    Route::get('/members', function () {return view('admin.membersPage');})->name('admin.memberManagement');
    Route::get('/borrow', function () {return view('admin.borrowRequestPage');})->name('admin.borrowRequest');
    Route::get('/reservation', function () {return view('admin.reservationRequestPage');})->name('admin.reservationRequest');
    Route::get('/return', function () {return view('admin.bookReturnsPage');})->name('admin.bookReturn');
    Route::get('/penalty', function () {return view('admin.penaltyManagementPage');})->name('admin.penaltyManagement');
    Route::get('/reports', function () {return view('admin.reportsPage');})->name('admin.report');

});

