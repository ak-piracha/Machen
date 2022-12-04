<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ToDoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//  ---Protected Routes---
Route::group(['middleware' => 'api'], function () {

    //Auth Routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/email/verification-notify', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth');
    Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth');
    //ToDo Routes
    Route::resource('/todo', ToDoController::class);
});

//  ---Public Routes---

//Auth Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
