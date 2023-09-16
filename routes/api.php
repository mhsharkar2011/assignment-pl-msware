<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('users',UserController::class);
Route::resource('transactions',TransactionController::class);

// deposit
Route::get('deposit', [UserController::class,'showDeposit'])->name('user-deposit-show');
Route::post('deposit', [UserController::class,'deposit'])->name('user-deposit');

// withdrawal
Route::post('withdrawal', [UserController::class,'withdrawal'])->name('user-withdrawal');

