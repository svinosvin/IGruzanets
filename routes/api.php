<?php

use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AutoCategoryController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubResourceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderTypesControllers;
use App\Http\Controllers\ServiceTypesControllers;
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


//User
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['prefix'=>'user', 'middleware' => ['auth:sanctum', 'abilities:user']], function (){

    Route::get('/profile', [AuthController::class, 'profile']);
    Route::patch('/updateProfile/{id}', [AuthController::class, 'changeUserData']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', 'abilities:user']);;
});

//Admin
Route::prefix('admin')->group(function (){
    //Admin login post request
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum', 'abilities:admin']], function (){
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/data', [AdminAuthController::class, 'index']);
        Route::get('/profile', [AdminController::class, 'profile']);
        Route::patch('/updateProfile', [AdminController::class, 'changeAdminData']);
    });
});

Route::group(['middleware' => ['auth:sanctum', 'abilities:admin']], function (){


    Route::prefix('employees')->group(function (){
        Route::get('/', [EmployeeController::class, 'getAll']);
        Route::get('/{id}',[EmployeeController::class, 'getById']);

        Route::post('/', [EmployeeController::class,'store']);
        Route::patch('/{id}', [EmployeeController::class,'update']);
        Route::delete('/{id}', [EmployeeController::class,'destroy']);
    });
    Route::prefix('orders')->group(function (){
        Route::get('/', [OrderController::class, 'getAll']);
        Route::post('/newOrder', [OrderController::class, 'getAll']);

    });

    Route::prefix('users')->group(function (){
        Route::get('/', [UserController::class, 'getAll']);
        Route::get('/{id}',[UserController::class, 'getById']);

        Route::post('/', [UserController::class,'store']);
        Route::patch('/{id}', [UserController::class,'update']);
        Route::delete('/{id}', [UserController::class,'destroy']);
    });

});


Route::get('/order_types', [OrderTypesControllers::class, 'getAll']);
Route::get('/service_types', [ServiceTypesControllers::class, 'getAll']);


Route::prefix('companies')->group(function (){
    Route::get('/', [CompanyController::class, 'getAll']);
    Route::get('/{id}',[CompanyController::class, 'getById']);

    Route::post('/', [CompanyController::class,'store']);
    Route::patch('/{id}', [CompanyController::class,'update']);
    Route::delete('/{id}', [CompanyController::class,'destroy']);
});


Route::prefix('driver')->group(function (){
    Route::get('/', [DriverController::class, 'getAll']);
    Route::get('/{id}',[DriverController::class, 'getById']);

    Route::post('/', [DriverController::class,'store']);
    Route::post('/{id}', [DriverController::class,'update']);
    Route::delete('/{id}', [DriverController::class,'destroy']);
});

Route::prefix('auto')->group(function (){
    Route::get('/', [AutoController::class, 'getAll']);
    Route::get('/{id}',[AutoController::class, 'getById']);

    Route::post('/', [AutoController::class,'store']);
    Route::post('/{id}', [AutoController::class,'update']);
    Route::delete('/{id}', [AutoController::class,'destroy']);
});

Route::prefix('auto_category')->group(function (){
    Route::get('/', [AutoCategoryController::class, 'getAll']);
    Route::get('/{id}',[AutoCategoryController::class, 'getById']);

    Route::post('/', [AutoCategoryController::class,'store']);
    Route::patch('/{id}', [AutoCategoryController::class,'update']);
    Route::delete('/{id}', [AutoCategoryController::class,'destroy']);
});

Route::prefix('resource')->group(function (){
    Route::get('/', [ResourceController::class, 'getAll']);
    Route::get('/small', [ResourceController::class, 'getSmallAll']);

    Route::get('/{id}',[ResourceController::class, 'getById']);

    Route::post('/', [ResourceController::class,'store']);
    Route::patch('/{id}', [ResourceController::class,'update']);
    Route::delete('/{id}', [ResourceController::class,'destroy']);
});

Route::prefix('sub_resource')->group(function (){
    Route::get('/', [SubResourceController::class, 'getAll']);
    Route::get('/{id}',[SubResourceController::class, 'getById']);

    Route::post('/', [SubResourceController::class,'store']);
    Route::patch('/{id}', [SubResourceController::class,'update']);
    Route::delete('/{id}', [SubResourceController::class,'destroy']);
});

Route::prefix('service')->group(function (){
    Route::get('/', [ServiceController::class, 'getAll']);
    Route::get('/{id}',[ServiceController::class, 'getById']);

    Route::post('/', [ServiceController::class,'store']);
    Route::post('/{id}', [ServiceController::class,'update']);
    Route::delete('/{id}', [ServiceController::class,'destroy']);
});

Route::prefix('orders')->group(function (){
    Route::get('/', [OrderController::class, 'getAll']);
    Route::get('/{id}', [OrderController::class, 'getById']);

    Route::post('/{id}', [OrderController::class, 'store']);
    Route::patch('/{id}', [OrderController::class, 'update']);
    Route::get('/findCar/{id}', [OrderController::class, 'findCarForOrder']);
    Route::get('/findDriver/{id}', [OrderController::class, 'findDriverForOrder']);
    Route::get('/acceptOrder/{id}', [OrderController::class, 'acceptOrder']);
    Route::get('/finishOrder/{id}', [OrderController::class, 'finishOrder']);

    Route::get('/declineOrder/{id}', [OrderController::class, 'declineOrder']);
    Route::delete('/{id}', [OrderController::class, 'destroy']);

});


