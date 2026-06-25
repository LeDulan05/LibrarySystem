<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Illuminate\Http\Request $request) {
    $totalBooks = \App\Models\Book::count();
    $totalStudents = \App\Models\User::count(); // Assuming all users are students muna habang wala pa si admin side
    
    $user = clone $request->user();
    $user->load(['transactions.book', 'reservations.book', 'transactions.penalty']);
    
    $recommendedBooks = \App\Models\Book::inRandomOrder()->limit(4)->get();
    
    return view('user.overviewPage', compact('totalBooks', 'totalStudents', 'user', 'recommendedBooks'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/notifications', function (\Illuminate\Http\Request $request) {
    $user = clone $request->user();
    $user->load(['transactions.book', 'reservations.book']);
    
    $notifications = collect();

    foreach ($user->transactions as $t) {
        $notifications->push([
            'type' => 'Borrow Request',
            'status' => $t->status,
            'book_title' => $t->book->title ?? 'Unknown Book',
            'date' => $t->updated_at,
            'is_unread' => $t->updated_at > now()->subDays(2),
            'message' => $t->status === 'active' ? 'has been approved. Please pick it up within 3 days.' :
                         ($t->status === 'pending' ? 'is pending approval by the admin.' :
                         ($t->status === 'returned' ? 'has been successfully returned.' : 'has been updated.'))
        ]);
    }

    foreach ($user->reservations as $r) {
        $notifications->push([
            'type' => 'Reservation',
            'status' => $r->status,
            'book_title' => $r->book->title ?? 'Unknown Book',
            'date' => $r->updated_at,
            'is_unread' => $r->updated_at > now()->subDays(2),
            'message' => $r->status === 'fulfilled' ? 'has been approved and is ready for pickup.' :
                         ($r->status === 'pending' ? 'is currently in queue (Position #' . ($r->queue_position ?? '-') . ').' :
                         ($r->status === 'closed' ? 'has been closed.' : 'has been updated.'))
        ]);
    }

    $notifications = $notifications->sortByDesc('date');

    return view('user.notificationsPage', compact('notifications'));
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
Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->middleware(['auth', 'verified'])->name('reservations.destroy');
Route::get('/penalties', [PenaltyController::class, 'index'])->middleware(['auth', 'verified'])->name('penalties');

Route::post('/library/{book}/borrow', [BorrowController::class, 'store'])->middleware(['auth', 'verified'])->name('library.borrow');
Route::delete('/borrow/{transaction}', [BorrowController::class, 'destroy'])->middleware(['auth', 'verified'])->name('borrow.destroy');
Route::post('/library/{book}/reserve', [ReservationController::class, 'store'])->middleware(['auth', 'verified'])->name('library.reserve');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\Admin\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'store']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('admin.logout');
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

