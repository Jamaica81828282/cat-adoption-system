<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdoptController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Livewire\AdminApplications;
use App\Http\Controllers\CatController;
use App\Http\Controllers\AdminCatController;
use App\Http\Controllers\Auth\NewPasswordController;

Route::get('/password/verify-otp', [NewPasswordController::class, 'showOtpForm'])
    ->name('password.verify-otp.form');

Route::post('/password/verify-otp', [NewPasswordController::class, 'verifyOtp'])
    ->name('password.verify-otp');
 
Route::get('/force-create-admin', function() {
    try {
        $user = \App\Models\User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => \Hash::make('123456789'),
                'is_admin' => 1,
            ]
        );
        return "Admin created/updated! Email: admin@gmail.com, Password: 123456789, is_admin: " . $user->is_admin;
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
Route::get('/view-users', function() {
    $users = \App\Models\User::all();
    return response()->json($users);
});

// ==============================
// Public Routes
// ==============================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/adopt', [AdoptController::class, 'index'])->name('adopt.index');
Route::get('/cats/{id}', [AdoptController::class, 'show'])->name('cats.show');

// ==============================
// User Routes (Authenticated Users)
// ==============================
Route::middleware(['auth', 'verified'])->group(function () {

    // User Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Applications - FIXED ORDER
    Route::get('/applications', [ApplicationController::class, 'index'])
        ->name('applications.index');
    Route::get('/applications/create/{catId}', [ApplicationController::class, 'create'])
        ->name('applications.create');
    Route::post('/applications/{catId}', [ApplicationController::class, 'store'])
        ->name('applications.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================
// Admin Routes (Authenticated + AdminMiddleware)
// ==============================
Route::middleware(['auth', AdminMiddleware::class])->group(function () {

    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    // Admin Applications Management
    Route::get('/admin/applications', [AdminController::class, 'applications'])
        ->name('admin.applications.index');
    Route::post('/admin/applications/{id}/update-status', [AdminController::class, 'updateStatus'])
        ->name('admin.applications.updateStatus');
    
    // Admin Cats Management
    Route::get('/admin/cats', [AdminCatController::class, 'index'])->name('admin.cats.index'); 
    Route::patch('/admin/cats/{id}/status', [AdminCatController::class, 'updateStatus'])->name('admin.cats.updateStatus');
    Route::get('/admin/cats/create', [AdminCatController::class, 'create'])
         ->name('admin.cats.create');
    Route::post('/admin/cats', [AdminCatController::class, 'store'])
         ->name('admin.cats.store');
});
// In your authenticated user routes section, add:
Route::get('/applications/{id}', [ApplicationController::class, 'show'])
    ->name('applications.show');
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/cats', [AdminCatController::class, 'index'])->name('cats.index');
    Route::get('/cats/create', [AdminCatController::class, 'create'])->name('cats.create');
    Route::post('/cats', [AdminCatController::class, 'store'])->name('cats.store');
    Route::get('/cats/{id}/edit', [AdminCatController::class, 'edit'])->name('cats.edit'); // ✅ NEW
    Route::put('/cats/{id}', [AdminCatController::class, 'update'])->name('cats.update'); // ✅ NEW
    Route::delete('/cats/{id}', [AdminCatController::class, 'destroy'])->name('cats.destroy'); // ✅ NEW
    Route::patch('/cats/{id}/status', [AdminCatController::class, 'updateStatus'])->name('cats.updateStatus');
});
require __DIR__.'/auth.php';