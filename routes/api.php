<?php

use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\AuthController;
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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/get', [AdminAuthController::class, 'index'])->middleware(['auth:sanctum', 'abilities:admin']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->middleware(['auth:sanctum', 'abilities:admin']);



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', 'abilities:user']);;
Route::get('/', [AuthController::class, 'index'])->middleware(['auth:sanctum', 'abilities:user']);
//
//Route::post('/login', [AdminAuthController::class, 'login']);
//Route::get('/', [AdminAuthController::class, 'index']);
