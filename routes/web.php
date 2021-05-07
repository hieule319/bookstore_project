<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;

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

Route::get('/', function () {
    return view('welcome');
});

//User
Route::middleware(['AlreadyLoggedIn'])->group(function () {
    Route::get('login',[UserAuthController::class, 'login']);
    Route::get('register',[UserAuthController::class, 'register']);

    //Login Google
    Route::get('redirect',[UserAuthController::class, 'redirectToProvider']);
    Route::get('/callback',[UserAuthController::class, 'handleProviderCallback']);
});

Route::post('create',[UserAuthController::class, 'create'])->name('auth.create');
Route::post('check',[UserAuthController::class, 'check'])->name('auth.check');

//Check login
Route::middleware(['isLogged'])->group(function () {
    Route::get('home',[UserAuthController::class, 'home']);
    Route::get('logout',[UserAuthController::class, 'logout']);
    
    
    //category
    Route::resource('category',CategoryController::class);
    Route::get('category-show/{id}',[CategoryController::class, 'getCategoryById']);
    Route::post('category-update',[CategoryController::class, 'updateCategory'])->name('category.update');
    Route::get('category-delete/{id}',[CategoryController::class, 'deleteCategory']);
    Route::get('category-status/{id}/{status}',[CategoryController::class, 'updateStatusCategory']);

    //Unit
    Route::resource('unit',UnitController::class);

    //Category Detail
    
});


