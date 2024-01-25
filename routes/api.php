<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\LogOutController;
use App\Http\Controllers\Master\AddressController;

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

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('login', [LoginController::class, 'login'])->name('loginUser');
    Route::post('verify-otp', [VerificationController::class, 'verifyOtp'])->name('verifyOtp');
    Route::post('password-login', [LoginController::class, 'login'])->name('loginPassworsUser');
    Route::post('resend-otp', [OtpController::class, 'resendOtp'])->name('resendOtp');
    Route::any('check-forgot-password', [ForgotPasswordController::class, 'checkForgotPassword'])->name('checkForgotPassword');
    Route::post('submit-forget-password', [ForgotPasswordController::class, 'submitForgetPassword'])->name('submitForgetPassword');
    Route::post('password-reset', [ResetPasswordController::class, 'submitResetPasswordForm'])->name('passwordResetSubmit');
    Route::post('logout',[LogOutController::class,'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::group(['prefix' => 'country', 'as' => 'country.'], function () {
        Route::get('/', [AddressController::class, 'country'])->name('index');
        Route::post('/store', [AddressController::class, 'addCountry'])->name('store');
        Route::get('/edit/{id}', [AddressController::class, 'editCountry'])->name('edit');
        Route::post('/update/{id}', [AddressController::class, 'updateCountry'])->name('update');
        Route::get('/delete/{id}', [AddressController::class, 'deleteCountry'])->name('delete');
    });
});
