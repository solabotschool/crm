<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {return redirect('/home');})->name('index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/invoice', [App\Http\Controllers\HomeController::class, 'invoice'])->name('invoice');

Route::get('/add/{id}', [App\Http\Controllers\HomeController::class, 'addInv'])->name('add');
Route::get('/get/{id}', [App\Http\Controllers\HomeController::class, 'getInv'])->name('get');
Route::get('/del/{id}', [App\Http\Controllers\HomeController::class, 'delInv'])->name('del');

Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');

Route::get('/quotePDF/{id}', [App\Http\Controllers\HomeController::class, 'quotePDF'])->name('quotePDF');
Route::get('/requestPDF/{id}', [App\Http\Controllers\HomeController::class, 'requestPDF'])->name('requestPDF');
Route::get('/receiptPDF/{id}', [App\Http\Controllers\HomeController::class, 'receiptPDF'])->name('receiptPDF');
Route::get('/deliverPDF/{id}', [App\Http\Controllers\HomeController::class, 'deliverPDF'])->name('deliverPDF');

