<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

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

Route::post('registrasi', [UserController::class, 'registrasi']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('role:admin')->get('/admin-dashboard', function () {
    // ...
});

Route::middleware('role:freelancer')->get('/freelancer-jobs', function () {
    // ...
});

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::post('/verifikasi-email', [UserController::class, 'verifikasiEmail']);
    Route::get('/current', [UserController::class, 'currentUser']);
    Route::post('update-profile', [UserController::class, 'updateProfile']);
});
