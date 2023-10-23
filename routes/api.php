<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkinController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PassportController;
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

Route::post('register', [PassportController::class, 'register'])->name('api.register');
Route::post('login', [PassportController::class, 'login'])->name('api.login');

Route::group(['prefix' => 'skins'], function() {
    Route::get('/', [SkinController::class, 'read'])->name('api.skins.read');
    Route::post('/', [SkinController::class, 'create'])->name('api.skins.create');
    Route::put('/{id}', [SkinController::class, 'update'])->name('api.skins.update');
    Route::delete('/{id}', [SkinController::class, 'delete'])->name('api.skins.delete');
});
Route::get('/skin/getskin/{id}', [SkinController::class,'readOne'])->name('api.skins.readOne');
