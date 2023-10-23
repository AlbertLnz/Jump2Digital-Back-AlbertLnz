<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkinController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\SkinControllerAdmin;

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

Route::get('/skins/available', [SkinController::class, 'availableSkins'])->name('api.skins.available'); // 1. GET /skins/avaible - Devuelve una lista de todas las skins disponibles para comprar
Route::post('/skins/buy/{skin_id}', [SkinController::class, 'buySkin'])->name('api.skins.buy')->middleware('auth:api'); // 2. POST /skins/buy - Permite a los usuarios adquirir una skin y guardarla en la base de datos



Route::group(['prefix' => 'skins'], function() {
    Route::get('/', [SkinControllerAdmin::class, 'read'])->name('api.skins.read');
    Route::post('/', [SkinControllerAdmin::class, 'create'])->name('api.skins.create');
    Route::put('/{id}', [SkinControllerAdmin::class, 'update'])->name('api.skins.update');
    Route::delete('/{id}', [SkinControllerAdmin::class, 'delete'])->name('api.skins.delete');
});
Route::get('/skin/getskin/{id}', [SkinControllerAdmin::class,'readOne'])->name('api.skins.readOne');
