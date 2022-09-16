<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RouteController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// category list api
Route::get("products/list",[RouteController::class,"productList"]);

//order list api
Route::get("orders/list",[RouteController::class,"ordersList"]);

// users list api
Route::get("users/list",[RouteController::class,"userList"]);

// create category api
Route::post("create/pizza",[RouteController::class,"create"]);

// create contact api
Route::post("create/contact",[RouteController::class,"contact"]);

// delete category api
Route::get("delete/category/{id}",[RouteController::class,"deleteCategory"]);

// details category api
Route::get("detail/category/{id}",[RouteController::class,"detailCategory"]);

// update category api
Route::post("update/category",[RouteController::class,"updateCategory"]);

