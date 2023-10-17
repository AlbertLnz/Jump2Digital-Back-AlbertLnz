<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkinController;

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

Route::group(['prefix' => 'skins'], function() {
    Route::get('/', [SkinController::class, 'read'])->name('api.skins.read');
    Route::post('/', [SkinController::class, 'create'])->name('api.skins.create');
    Route::put('/{id}', [SkinController::class, 'update'])->name('api.skins.update');
    Route::delete('/{id}', [SkinController::class, 'delete'])->name('api.skins.delete');
});