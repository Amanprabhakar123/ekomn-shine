<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\APIAuth\AuthController;
use App\Http\Controllers\APIAuth\ResetController;
use App\Http\Controllers\Auth\AuthViewController;
use App\Http\Controllers\APIAuth\ForgotController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\APIAuth\RegisterController;
use App\Http\Controllers\APIAuth\VerificationController;
use App\Http\Controllers\APIAuth\ApiRegistraionController;

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
})->name('home');

Route::get('buyer/login', [AuthViewController::class, 'loginFormView'])->name('buyer.login');
Route::get('supplier/login', [AuthViewController::class, 'loginFormView'])->name('supplier.login');
Route::get('buyer/register', [AuthViewController::class, 'loginFormView'])->name('buyer.register');
Route::get('supplier/register', [AuthViewController::class, 'loginFormView'])->name('supplier.register');
Route::get('supplier/forget', [AuthViewController::class, 'loginFormView'])->name('supplier.forget');
Route::get('buyer/forget', [AuthViewController::class, 'loginFormView'])->name('buyer.forget');
Route::get('reset', [AuthViewController::class, 'loginFormView'])->name('password.reset');
Route::get('verify/email', [ResetController::class, 'showVerifyForm'])->name('verification.verify');

Route::group(['prefix' => 'auth/google', 'as' => 'auth.google.'], function () {
    Route::get('/', [GoogleController::class, 'redirectToGoogle'])->name('redirect');
    Route::get('/call-back', [GoogleController::class, 'handleGoogleCallback'])->name('callback');
});

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Route group for API authentication routes
Route::group(['prefix' => 'api'], function () {
    Route::post('register', [RegisterController::class, 'registerUser']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('password/forget', [ForgotController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetController::class, 'reset']);
    Route::post('resend', [VerificationController::class, 'resend']);
    Route::post('verify', [VerificationController::class, 'verify'])->name('verify');
    Route::post('registration', [ApiRegistraionController::class, 'setData']);
});

// Route group for authenticated routes
Route::middleware(['api', 'jwt.auth', 'emailverified'])->group(function () {
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
