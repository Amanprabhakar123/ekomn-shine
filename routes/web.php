<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIAuth\ResetController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('password/reset', [ResetController::class, 'postReset'])->name('password.reset');
Route::get('verify/email', [ResetController::class, 'showVerifyForm'])->name('verification.verify');
