<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\user\AjaxController;
use App\Http\Controllers\user\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(["admin_auth"])->group(function(){
    // login /register
Route::redirect('/', 'loginPage');
Route::get('loginPage',[AuthController::class,"loginPage"])->name("auth#loginPage");
Route::get('registerPage',[AuthController::class,"registerPage"])->name("auth#registerPage");
});


Route::middleware(['auth'])->group(function () {

    // dashboard
    Route::get('dashboard',[AuthController::class,"dashboard"])->name("dashboard");

    // admin
    Route::middleware(["admin_auth"])->group(function(){
        // category
        Route::group(["prefix" => "category"],function(){
        Route::get('/list',[CategoryController::class,"list"])->name("admin#categoryListPage");
        Route::get("/create/page",[CategoryController::class,"createPage"])->name("admin#categoryCreatePage");
        Route::post("create",[CategoryController::class,"create"])->name("admin#create");
        Route::get("delete/{id}",[CategoryController::class,"delete"])->name("category#delete");
        Route::get('edit/{id}',[CategoryController::class,"edit"])->name('category#edit');
        Route::post("update/{id}",[CategoryController::class,'update'])->name('category#update');
        });

        // admin account
        Route::prefix('admin')->group(function(){
            // password
            Route::get("password/chagenPage",[AdminController::class,"changePasswordPage"])->name("admin#changePasswordPage");
            Route::post("change/password",[AdminController::class,"changePassword"])->name("admin#changePassword");

            // account
            Route::get("details",[AdminController::class,"details"])->name("admin#details");
            Route::get("edit",[AdminController::class,"edit"])->name("admin#edit");
            Route::post('update/{id}',[AdminController::class,'update'])->name("admin#update");

            // admin list\
            Route::get("list",[AdminController::class,"list"])->name("admin#list");
            Route::get("delete/{id}",[AdminController::class,'delete'])->name("admin#delete");
            Route::get("changeRole/{id}",[AdminController::class,"changeRole"])->name("admin#changeRole");
            Route::post("updateChangeRole/{id}",[AdminController::class,"roleUpdate"])->name("admin#updateChangeRole");
            Route::get("ajax/change/role",[AdminController::class,"ajaxChangeRole"])->name("admin#changeRole");


        });

        // products
        Route::prefix("products")->group(function(){
            Route::get('list',[ProductController::class,"list"])->name('product#list');
            Route::get('createPage',[ProductController::class,"createPage"])->name('product#createPage');
            Route::post('create',[ProductController::class,"create"])->name("product#create");
            Route::get('delete/{id}',[ProductController::class,'delete'])->name("product#delete");
            Route::get('edit/{id}',[ProductController::class,"edit"])->name("product#edit");
            Route::get("updatePage/{id}",[ProductController::class,"updatePage"])->name("product#updatePage");
            Route::post("update/{id}",[ProductController::class,"update"])->name("product#update");
        });

        Route::prefix("user")->group(function(){
            // users list
            Route::get("users/list",[AdminController::class,"usersList"])->name("admin#usersList");
            Route::get("usersDelete/{id}",[AdminController::class,"usersDelete"])->name("admin#usersDelete");
            Route::get("ajax/userChangeRole",[AdminController::class,"userChangeRole"])->name("admin#userChangeRole");
        });

        Route::prefix("order")->group(function(){
            Route::get("list",[OrderController::class,"list"])->name("admin#orderList");
            Route::get("change/status",[OrderController::class,"changeStatus"])->name("order#changeStatus");
            Route::get("ajax/change/status",[OrderController::class,"ajaxChangeStatus"])->name("admin#changeStatus");
            Route::get("listInfo/{orderCode}",[OrderController::class,"listInfo"])->name("admin#listInfo");
        });

        // admin contact list
        Route::prefix("contact")->group(function(){
            Route::get("list",[AdminController::class,"contactList"])->name("admin#contactList");
            Route::get("details/{id}",[AdminController::class,"contactDetails"])->name("admin#contactDetails");
            Route::get("block/{id}",[AdminController::class,"block"])->name("admin#contactBlock");
        });
    });


    // user
    // home
    Route::group(["prefix" => "user","middleware" => "user_auth"],function(){
        Route::get('home',[UserController::class,"home"])->name("user#home");
        Route::get('filter/{categoryId}',[UserController::class,"filter"])->name("user#filter");
        Route::get("history",[UserController::class,"history"])->name("user#history");


        Route::prefix("pizza")->group(function(){
            Route::get("details/{pizzaId}",[UserController::class,"pizzaDetails"])->name("user#pizzaDetails");
        });

        Route::prefix("password")->group(function(){
            Route::get("change",[UserController::class,"change"])->name("user#changePasswordPage");
            Route::post("change",[UserController::class,"changePassword"])->name("user#changePassword");
        });

        Route::prefix("account")->group(function(){
            Route::get("change",[UserController::class,"accountChange"])->name("user#changeAccount");
            Route::post("change/{id}",[UserController::class,"userAccountChange"])->name("user#accontchange");
        });

        Route::prefix("ajax")->group(function(){
            Route::get('pizza/list',[AjaxController::class,"pizzaList"])->name("ajax#pizzalist");
            Route::get("cart",[AjaxController::class,"addToCart"])->name("pizza#addToCart");
            Route::get("order",[AjaxController::class,"order"])->name("ajax#order");
            Route::get("clear/cart",[AjaxController::class,"clearCart"])->name("ajax#clearCart");
            Route::get("clear/row/cart",[AjaxController::class,"clearRowCart"])->name("ajax#clearRowCart");
            Route::get("increaseViewCount",[AjaxController::class,"increaseViewCount"])->name("ajax#increaseViewCount");
        });

        Route::prefix("cart")->group(function(){
            Route::get("list",[UserController::class,"cartList"])->name("cart#list");
        });

        Route::prefix("contact")->group(function(){
            Route::get("contactPage",[ContactController::class,"contactPage"])->name("user#contactPage");
            Route::post("contact",[ContactController::class,"contact"])->name("user#contact");
        });
    });
});



