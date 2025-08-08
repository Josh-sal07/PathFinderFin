<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\User\OfficeViewerController;

// ✅ Landing Page
Route::get('/', function () {
    return view('welcome');
});

// ✅ Auth Routes (Laravel Breeze)
require __DIR__.'/auth.php';

// ✅ Profile Routes (Authenticated Users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Admin Dashboard
Route::get('/dashboard', [OfficeController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    

// ✅ Admin Office Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('offices', OfficeController::class);
    Route::delete('offices/photos/{photo}', [OfficeController::class, 'destroyPhoto'])->name('offices.delete-photo');
    // Route::put('offices/{office}', [OfficeController::class, 'update'])->name('offices.update');
    Route::view('/about', 'admin.about')->name('about');
    Route::view('/contact', 'admin.contact')->name('contact');
});

// ✅ AR Scan Page
Route::get('/scan', function () {
    return view('ar.scan');
})->name('scan');

// ✅ After QR Scan, set session and redirect to office selection
Route::get('/redirect-after-scan', function () {
    session(['scanned' => true]);
    return redirect()->route('selectOffices.index');
    Route::get('/selectOffices', [OfficeViewerController::class, 'index'])->name('offices.index');
})->name('redirect.after.scan');

// ✅ Public Route – Requires QR Scan
Route::get('/selectOffices', function () {
    if (!session('scanned')) {
        return redirect('/scan')->with('error', 'You must scan the QR code first.');
    }
    return app(OfficeViewerController::class)->index();
    
})->name('selectOffices.index');

// ✅ Show Office Navigation – Requires QR Scan
Route::get('/selectOffices/{id}', function ($id) {
    if (!session('scanned')) {
        return redirect('/scan')->with('error', 'You must scan the QR code first.');
    }
    return app(OfficeViewerController::class)->show($id);
    
})->name('selectOffices.show');

// ✅ Office Navigation Route (with arrows etc.)
Route::get('/offices/{office}/navigate', [NavigationController::class, 'navigate'])->name('selectOffices.navigate');

// ✅ Optional: view-office by ID (also requires scan)
Route::get('/view-office/{id}', function ($id) {
    if (!session('scanned')) {
        return redirect('/scan')->with('error', 'You must scan the QR code first.');
    }
    return app(OfficeViewerController::class)->show($id);
    
})->name('user.view.office');




