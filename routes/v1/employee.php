<?php
namespace App;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Site\HomeController;
use App\Http\Controllers\V1\Site\Auth\LoginController;
use App\Http\Controllers\V1\Site\Auth\RegisterController;
use App\Http\Controllers\V1\Site\Auth\ActiveCodeController;
use App\Http\Controllers\V1\Site\Auth\ResetPasswordController;

Route::get('/', function () {
    // auth()->logout();
    return view('pages.site.auth.login');
});

/* -------------------------------------------------------------------------- */
/*                                 auth route                                 */
/* -------------------------------------------------------------------------- */
// Route::prefix('auth')->group(function(){

    Route::controller(LoginController::class)->group(function(){

        // Route::get('login', 'showLogin')->name('login');
        // Route::post('send-otp', 'sendOtp')->name('send-otp');
        // Route::get('login/otp', 'showLoginOtp')->name('login-otp');
        // Route::post('login', 'login');
        Route::get('logout', 'logout')->name('logout');
        // Route::get('dashboard', 'dashboard')->name('dashboard');

        Route::get('login', 'showLogin')->name('login')->middleware('guest');
        Route::post('login', 'login')->middleware('guest');

    });

    Route::controller(ActiveCodeController::class)->middleware('guest')->group(function(){

        Route::get('active-code', 'showActiveCode')->name('active-code');
        Route::post('active-code', 'activeCode');

    });
// });

/* -------------------------------------------------------------------------- */
/*                                 ResetPassword route                          */
/* -------------------------------------------------------------------------- */
Route::controller(ResetPasswordController::class)->middleware('auth')->group(function(){
    Route::get('verify-phone', 'showPhonePage')->name('reset-password-phone');
    Route::post('send-code', 'sendCode')->name('reset-password-code');
    Route::get('code-page', 'showCodePage')->name('reset-password-code-page');
    Route::post('verify-code', 'verifyCode')->name('verify-code');
    Route::post('reset-password', 'resetPassword')->name('reset-password');
    Route::get('reset-password-page', 'showResetPasswordePage')->name('reset-password-page');

});

/* -------------------------------------------------------------------------- */
/*                                 Home route                                 */
/* -------------------------------------------------------------------------- */
Route::controller(HomeController::class)->middleware('auth')->group(function(){
    Route::get('home', 'home')->name('home');
});




