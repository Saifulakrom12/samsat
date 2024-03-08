<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// login

Route::get('/', [Logincontroller::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// middelware
Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'], function() {

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    Route::get('/dashboard', [BarangController::class, 'dashboard'])->name('dashboard');

    // menampilkan data barang
    Route::get('/barang', [BarangController::class, 'barang'])->name('barang');
    // insert & save data barang
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang/simpan', [BarangController::class, 'simpan'])->name('barang.simpan');

    // Menampilkan formulir edit barang
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    // Update data barang
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');

    // hapus data
    Route::delete('/barang/{id}', [BarangController::class, 'delete'])->name('barang.delete');




    // user
    Route::get('/user', [UserController::class, 'index'])->name('index');

    Route::get('/create', [UserController::class, 'user_create'])->name('user.create');
    Route::post('/simpan', [UserController::class, 'user_simpan'])->name('user.simpan');

    // Route untuk edit user
    Route::get('/edit/{id}', [UserController::class, 'user_edit'])->name('user.edit');
    Route::put('/update/{id}', [UserController::class, 'user_update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');

});

