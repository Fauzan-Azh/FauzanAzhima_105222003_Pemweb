<?php

use Illuminate\Support\Facades\Route; // Mengimpor kelas Route untuk mendefinisikan rute
use App\Http\Controllers\AuthController; // Mengimpor AuthController untuk autentikasi
use App\Http\Controllers\SchedulerController; // Mengimpor SchedulerController untuk mengelola event

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendefinisikan rute web untuk aplikasi Anda. Rute-rute ini
| akan dimuat oleh RouteServiceProvider dan semuanya akan dimasukkan ke dalam
| grup middleware "web". Buat sesuatu yang hebat!
|
*/

// Rute untuk halaman welcome (landing page)
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk proses autentikasi (login)
Route::post('auth', [AuthController::class, 'auth'])->name('auth');

// Rute untuk proses logout
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// Grup rute untuk mengelola event dengan prefix 'event' dan nama rute 'event.'
Route::prefix('event')->name('event.')->group(function(){
    // Rute untuk halaman utama event
    Route::get('/', [SchedulerController::class, 'home'])->name('home');

    // Rute untuk mengambil data event (mungkin digunakan untuk API atau AJAX)
    Route::get('getData', [SchedulerController::class, 'getData'])->name('getData');

    // Rute untuk mengirim (menyimpan) data event baru
    Route::post('submit', [SchedulerController::class, 'submit'])->name('submit');

    // Rute untuk memperbarui data event yang sudah ada
    Route::put('update', [SchedulerController::class, 'update'])->name('update');

    // Rute untuk menghapus data event
    Route::post('delete', [SchedulerController::class, 'delete'])->name('delete');

    // Rute untuk mengambil data event dalam format JSON
    Route::get('get-json', [SchedulerController::class, 'getJson'])->name('getJson');

    // Rute untuk mengambil data event tertentu (mungkin digunakan untuk edit atau detail)
    Route::get('get-selected-data', [SchedulerController::class, 'getSelectedData'])->name('getSelectedData');
});
