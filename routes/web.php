<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Halaman Untuk User (Umum, tanpa login)
|--------------------------------------------------------------------------
*/

// Beranda / Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Form Pemesanan
Route::get('/order', [OrderController::class, 'form'])->name('order.form');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// Halaman Invoice setelah pemesanan berhasil
Route::get('/invoice/{order}', [OrderController::class, 'invoice'])->name('order.invoice');


/*
|--------------------------------------------------------------------------
| Halaman Admin (Login Wajib)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Redirect setelah login ke halaman admin/menu
    Route::get('/dashboard', fn () => redirect()->route('menus.index'))->name('dashboard');

    // Halaman utama admin
    Route::get('/admin', fn () => redirect()->route('menus.index'))->name('admin.home');

    // Resource CRUD untuk menu
    Route::resource('menus', MenuController::class);
    // untuk melihat pemesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    //pesanan selesai
    Route::delete('/orders/{order}/done', [OrderController::class, 'markAsDone'])->name('orders.done');

    //excell
    Route::middleware(['auth'])->group(function () {
        Route::get('/orders/export', [OrderController::class, 'exportCsv'])->name('orders.export');

    // Tambahan fitur status & catatan
    Route::patch('/orders/{order}/status/{status}', [OrderController::class, 'updateStatus'])
        ->whereIn('status', ['diproses', 'selesai'])
        ->name('orders.status');

    Route::patch('/orders/{order}/note', [OrderController::class, 'updateNote'])
        ->name('orders.note');

    Route::post('/order/{order}/pay', [OrderController::class, 'pay'])->name('order.pay');

});
    

});

// Auth bawaan Laravel Breeze
require __DIR__.'/auth.php';