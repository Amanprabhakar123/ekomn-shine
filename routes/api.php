<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIAuth\AuthController;
use App\Http\Controllers\APIAuth\ResetController;
use App\Http\Controllers\APIAuth\ForgotController;
use App\Http\Controllers\APIAuth\RegisterController;
use App\Http\Controllers\APIAuth\VerificationController;
use App\Http\Controllers\APIAuth\ApiRegistraionController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// // Route group for API authentication routes
// Route::middleware('api')->group(function () {
//     Route::post('register', [RegisterController::class, 'registerUser']);
//     Route::post('login', [AuthController::class, 'login'])->name('login');
//     Route::post('logout', [AuthController::class, 'logout']);
//     Route::post('password/forget', [ForgotController::class, 'sendResetLinkEmail']);
//     Route::post('password/reset', [ResetController::class, 'reset']);
//     Route::post('resend', [VerificationController::class, 'resend']);
//     Route::post('verify', [VerificationController::class, 'verify'])->name('verify');
//     // Route::post('reistraion', [ApiRegistraionController::class, 'setData']);
// });

// // Route group for authenticated routes
// Route::middleware(['api', 'jwt.auth', 'emailverified'])->group(function () {
//     Route::post('refresh', [AuthController::class, 'refresh']);
//     Route::post('me', [AuthController::class, 'me']);
// });
