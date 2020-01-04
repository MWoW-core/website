<?php

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

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DownloadServerRealmlist;
use App\Http\Controllers\ListServers;
use App\Http\Controllers\ShowHome;
use App\Http\Controllers\ShowNews;
use App\Http\Controllers\ShowUser;
use App\Http\Controllers\ShowWelcome;
use Illuminate\Support\Facades\Route;

Route::get('/', ShowWelcome::class)->name('welcome');
Route::get('/news/{news}', ShowNews::class)->name('news.show');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

//Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
//Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
//Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::middleware('auth')->group(function () {
    Route::get('/home', ShowHome::class)->name('home');
});

Route::get('servers', ListServers::class)->name('servers.index');
Route::get('servers/{server}/realmlist', DownloadServerRealmlist::class)->name('servers.realmlist.show');

Route::get('users/{user}', ShowUser::class)->name('users.show');
