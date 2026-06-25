<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Illuminate\Http\Request $request) {
    $totalBooks = \App\Models\Book::count();
    $totalStudents = \App\Models\User::count(); // Assuming all users are students for now
    
    $user = clone $request->user();
    $user->load(['transactions.book', 'reservations.book', 'transactions.penalty']);
    
    $recommendedBooks = \App\Models\Book::inRandomOrder()->limit(4)->get();
    
    return view('user.overviewPage', compact('totalBooks', 'totalStudents', 'user', 'recommendedBooks'));
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
    Route::delete('/catalog/{id}', [BookController::class, 'destroy'])->name('admin.bookCatalog.destroy');
    Route::get('/add-book', [BookController::class, 'create'])->name('admin.addBook');
    Route::post('/add-book', [BookController::class, 'store'])->name('admin.bookCatalog.store');
    
    Route::get('/edit-book/{id}', [BookController::class, 'edit'])->name('admin.editBook');
    Route::put('/edit-book/{id}', [BookController::class, 'update'])->name('admin.updateBook');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.bookCategories');
    Route::get('/categories/{id}', [AdminCategoryController::class, 'show'])->name('admin.categories.show');

    // FIXED: Only point to the controller and delete the duplicate closure override line below it
    Route::get('/members', [MemberController::class, 'index'])->name('admin.memberManagement');
    Route::get('/members/{id}', [MemberController::class, 'show'])->name('admin.members.show');
    Route::post('/members/{id}/suspend', [MemberController::class, 'suspend'])->name('admin.members.suspend');

    Route::get('/borrow', function () {return view('admin.borrowRequestPage');})->name('admin.borrowRequest');
    Route::get('/reservation', function () {return view('admin.reservationRequestPage');})->name('admin.reservationRequest');
    Route::get('/return', function () {return view('admin.bookReturnsPage');})->name('admin.bookReturn');
    Route::get('/penalty', function () {return view('admin.penaltyManagementPage');})->name('admin.penaltyManagement');
    Route::get('/reports', function () {return view('admin.reportsPage');})->name('admin.report');
});

