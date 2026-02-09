<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
/*
|--------------------------------------------------------------------------zxqxs
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// --- MAIN DASHBOARD ROUTE ---
Route::get('/dashboard', function () {
    // 1. If user is a Landlord, redirect to their panel
    if (Auth::user()->role === 'landlord') {
        return redirect()->route('landlord.dashboard');
        Route::view('/settings', 'landlord.settings')->name('settings');
    }
    
    // 2. If user is a Tenant, let the Controller handle the math
    return app(TenantController::class)->index(); 
})->middleware(['auth', 'verified'])->name('dashboard');


// --- LANDLORD ROUTES ---
Route::middleware(['auth', 'verified'])->prefix('landlord')->name('landlord.')->group(function () {
    
    Route::get('/dashboard', [LandlordController::class, 'dashboard'])->name('dashboard');
    
    // Buildings & Tenants
    Route::post('/building', [LandlordController::class, 'storeBuilding'])->name('building.store');
    Route::delete('/building/{id}', [LandlordController::class, 'destroyBuilding'])->name('building.destroy');
    Route::post('/tenant', [LandlordController::class, 'storeTenant'])->name('tenant.store');
    Route::delete('/tenant/{id}', [LandlordController::class, 'destroyTenant'])->name('tenant.destroy');
    
    // Bills
    Route::post('/bill', [LandlordController::class, 'storeBill'])->name('bill.store');
    Route::patch('/bill/{id}', [LandlordController::class, 'updateBillStatus'])->name('bill.status');
    Route::delete('/bill/{id}', [LandlordController::class, 'destroyBill'])->name('bill.destroy');
    
    // ✅ UNCOMMENTED THESE ROUTES TO FIX YOUR ERROR
    Route::get('/bill/{id}/edit', [LandlordController::class, 'editBill'])->name('bill.edit');
    Route::put('/bill/{id}', [LandlordController::class, 'updateBill'])->name('bill.update');

    // Proofs
    Route::get('/bill/{id}/proof', [LandlordController::class, 'downloadProof'])->name('proof.download');

    // Settings
    Route::get('/settings', function () { return view('landlord.settings'); })->name('settings');
});


// --- TENANT ROUTES ---
Route::middleware(['auth', 'verified'])->prefix('portal')->name('tenant.')->group(function () {
    
    // 1. Upload Payment Proof
    Route::post('/bill/{id}/upload', [TenantController::class, 'uploadProof'])->name('upload');
    
    // 2. Download Invoice PDF
    Route::get('/bill/{id}/pdf', [TenantController::class, 'downloadInvoice'])->name('invoice.download');
    
    // 3. Optional: Reviews
    Route::post('/review', [TenantController::class, 'submitReview'])->name('review.store');
});


// --- PROFILE ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/theme', [ProfileController::class, 'updateTheme'])->name('profile.theme');
});

Route::get('/storage/{path}', function ($path) {
    // 1. Find the file in the private folder
    $path = storage_path('app/public/' . $path);

    // 2. If file doesn't exist, error 404
    if (!File::exists($path)) {
        abort(404);
    }

    // 3. Serve the file (Fake it as a public file)
    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->where('path', '.*');

require __DIR__.'/auth.php';