<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController; 
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\BorrowRequestController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController; 
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\PenaltyController as AdminPenaltyController;
use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\Member\CatalogController;
use App\Http\Controllers\Member\BorrowController;
use App\Http\Controllers\Member\ReservationController;
use App\Http\Controllers\Member\PenaltyController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function (Illuminate\Http\Request $request) {
    $totalBooks = \App\Models\Book::count();
    
    $totalStudents = \App\Models\User::where('role', 'member')
                                     ->where('status', 'active')
                                     ->count(); 
    
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

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/library', [CatalogController::class, 'index'])->middleware(['auth', 'verified'])->name('library');
Route::get('/library/{book}', [CatalogController::class, 'show'])->middleware(['auth', 'verified'])->name('library.show');
Route::get('/library/{book}/details', [CatalogController::class, 'details'])->middleware(['auth', 'verified'])->name('library.details');

Route::get('/borrowed', [BorrowController::class, 'index'])->middleware(['auth', 'verified'])->name('borrowed');

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

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'store']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('admin.logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/catalog', [BookController::class, 'index'])->name('admin.bookCatalog');
    Route::delete('/catalog/{id}', [BookController::class, 'destroy'])->name('admin.bookCatalog.destroy');
    Route::get('/add-book', [BookController::class, 'create'])->name('admin.addBook');
    Route::post('/add-book', [BookController::class, 'store'])->name('admin.bookCatalog.store');
    
    Route::get('/edit-book/{id}', [BookController::class, 'edit'])->name('admin.editBook');
    Route::put('/edit-book/{id}', [BookController::class, 'update'])->name('admin.updateBook');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.bookCategories');
    Route::get('/categories/{id}', [AdminCategoryController::class, 'show'])->name('admin.categories.show');
    Route::get('/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

    Route::get('/members', [MemberController::class, 'index'])->name('admin.memberManagement');
    Route::get('/members/{id}', [MemberController::class, 'show'])->name('admin.members.show');
    Route::post('/members/{id}/suspend', [MemberController::class, 'suspend'])->name('admin.members.suspend');

    Route::get('/borrow', [BorrowRequestController::class, 'index'])->name('admin.borrowRequest');
    Route::get('/borrow/{id}', [BorrowRequestController::class, 'show'])->name('admin.borrow.show');
    Route::post('/borrow/{id}/reject', [BorrowRequestController::class, 'reject'])->name('admin.borrow.reject');
    Route::post('/borrow/{id}/approve', [BorrowRequestController::class, 'approve'])->name('admin.borrow.approve');
    Route::get('/borrow/{id}/rejection', [BorrowRequestController::class, 'rejectionNotice'])->name('admin.borrow.rejection');
    Route::get('/borrow/{id}/receipt', [BorrowRequestController::class, 'receipt'])->name('admin.borrow.receipt');

    Route::get('/reservation', [AdminReservationController::class, 'index'])->name('admin.reservationRequest');
    Route::get('/reservation/{id}', [AdminReservationController::class, 'show'])->name('admin.reservation.show');
    Route::post('/reservation/{id}/approve', [AdminReservationController::class, 'approve'])->name('admin.reservation.approve');
    Route::post('/reservation/{id}/reject', [AdminReservationController::class, 'reject'])->name('admin.reservation.reject');
    Route::get('/reservation/{id}/receipt', [AdminReservationController::class, 'receipt'])->name('admin.reservation.receipt');

    Route::get('/return', [ReturnController::class, 'index'])->name('admin.bookReturn');

    Route::get('/penalty', [AdminPenaltyController::class, 'index'])->name('admin.penaltyManagement');
    Route::get('/penalty/member/{userId}', [AdminPenaltyController::class, 'show'])->name('admin.penalty.show');
    
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.report');
});

