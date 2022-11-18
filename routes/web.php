<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_index;
use App\Http\Controllers\C_barang;
use App\Http\Controllers\C_transaksi;
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

Route::get('/',[C_index::class,'index']);
Route::get('/home',[C_index::class,'index']);

Route::get('/barang',[C_barang::class,'index']);
Route::post('/barang/store',[C_barang::class,'store']);
Route::post('/barang/update/{id}',[C_barang::class,'update']);

Route::get('/transaksi',[C_transaksi::class,'index']);
Route::post('/transaksi/store',[C_transaksi::class,'store']);
Route::get('/transaksi{id}',[C_transaksi::class,'edit']);
Route::post('/transaksi/update/{id}',[C_transaksi::class,'update']);
Route::post('/transaksi/delete/{id}',[C_transaksi::class,'delete']);

Auth::routes();


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/', function () {
//     return view('index');
// });