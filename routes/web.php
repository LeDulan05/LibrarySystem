<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/catalog', [BookController::class, 'index'])->name('admin.bookCatalog');
    Route::get('/add-book', function () {return view('admin.addBookPage');})->name('admin.addBook');
    Route::get('/edit-book', function () {return view('admin.editBookPage');})->name('admin.editBook');
    Route::get('/categories', function () {return view('admin.categoriesPage');})->name('admin.bookCategories');
    Route::get('/members', function () {return view('admin.membersPage');})->name('admin.memberManagement');
    Route::get('/borrow', function () {return view('admin.borrowRequestPage');})->name('admin.borrowRequest');
    Route::get('/reservation', function () {return view('admin.reservationRequestPage');})->name('admin.reservationRequest');
    Route::get('/return', function () {return view('admin.bookReturnsPage');})->name('admin.bookReturn');
    Route::get('/penalty', function () {return view('admin.penaltyManagementPage');})->name('admin.penaltyManagement');
    Route::get('/reports', function () {return view('admin.reportsPage');})->name('admin.report');

});

