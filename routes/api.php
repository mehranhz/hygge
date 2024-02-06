<?php

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


Route::prefix('v1')->name('v1.')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        // user registration and authentication routes
        Route::post('/register', [\App\Http\Controllers\REST\Auth\AuthController::class, 'selfRegister'])->name('register');
        Route::post('/login-with-email', [\App\Http\Controllers\REST\Auth\AuthController::class, 'loginViaEmailAndPassword'])->name('login-with-email');

        // access control management routes
        Route::post('/role', [\App\Http\Controllers\REST\Auth\RoleController::class, 'create'])->name('role.create');
        Route::get('/role', [\App\Http\Controllers\REST\Auth\RoleController::class, 'index'])->name('role.get');
        Route::post('/permission', [\App\Http\Controllers\REST\Auth\PermissionController::class, 'create'])->name('permission.create');
        Route::get('/permission', [\App\Http\Controllers\REST\Auth\PermissionController::class, 'index'])->name('permission.get');
    });

});
