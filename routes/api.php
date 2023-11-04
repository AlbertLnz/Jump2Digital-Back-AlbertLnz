<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkinController;
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

Route::get('/skins/available', [SkinController::class, 'availableSkins'])->name('api.skins.available'); // 1. GET: api/skins/avaible - Devuelve una lista de todas las skins disponibles para comprar
Route::post('/skins/buy/{skin_id}', [SkinController::class, 'buySkin'])->name('api.skins.buy')->middleware('auth:api'); // 2. POST: api/skins/buy - Permite a los usuarios adquirir una skin y guardarla en la base de datos
Route::get('/skins/myskins', [SkinController::class, 'userSkins'])->name('api.skins.myskins')->middleware('auth:api'); // 3. GET: api/skins/myskins - Devuelve una lista de las skins compradas por el usuario
Route::put('skins/color', [SkinController::class, 'changeSkinColor'])->name('api.skins.updateColor')->middleware('auth:api'); // 4. PUT: api/skins/color - Permite a los usuarios cambiar el color de una skin comprada. 
Route::delete('skins/delete/{id}', [SkinController::class, 'deleteUserSkin'])->name('api.skin.delete')->middleware('auth:api'); // 5. DELETE: api/skins/delete/{id} - Permite a los usuarios eliminar una skin comprada. 
Route::get('/skin/getskin/{id}', [SkinControllerAdmin::class,'readOne'])->name('api.skins.readOne')->middleware('auth:api'); // 6. GET: api/skin/getskin/{id} - Devuelve una determinada skin.

// ADMIN ROUTES (CRUD SKIN)
Route::group(['prefix' => 'skins'], function() {
    Route::get('/', [SkinControllerAdmin::class, 'read'])->name('api.skins.read')->middleware(['auth:api', 'role:admin']); // MÁXIMA SEGURIDAD (CON KERNEL) -> Not login w/o message (500), Not role admin (403) without enter to controller
    Route::post('/', [SkinControllerAdmin::class, 'create'])->name('api.skins.create')->middleware('auth:api'); // BUENA SEGURIDAD -> Not login w/o message (500), Not role admin (403) entering in controller and give a error 403
    Route::put('/{id}', [SkinControllerAdmin::class, 'update'])->name('api.skins.update'); // CORRECTA SEGURIDAD (sólo control d'errores en el controlador) -> Not login with message (500), Not role admin (403) entering in controller and give a error 403
    Route::delete('/{id}', [SkinControllerAdmin::class, 'delete'])->name('api.skins.delete'); // SIN NINGUN TIPO DE SEGURIDAD (ni auth ni role)
});
