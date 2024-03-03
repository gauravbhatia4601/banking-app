<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth']], function(){
    Route::get('/', [Controller::class, 'index'])->name('');
    Route::get('/home', [Controller::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::match(['get','post'],'/deposit', [TransactionController::class, 'deposit'])->name('deposit');
    Route::match(['get','post'],'/withdraw', [TransactionController::class, 'withdraw'])->name('withdraw');
    Route::match(['get','post'],'/transfer', [TransactionController::class, 'transfer'])->name('transfer');
    Route::match(['get','post'],'/statement', [TransactionController::class, 'fetchStatements'])->name('statement');
});

Route::match(['get','post'], 'login', [AuthController::class, 'login'])->name('login');
Route::match(['get','post'],'register', [AuthController::class, 'register'])->name('register');