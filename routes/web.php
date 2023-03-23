<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
//auth route for admin
Route::group(['middleware' => ['auth','role:admin']], function() { 
    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
});

// for users
Route::group(['middleware' => ['auth', 'role:user']], function() { 
    Route::get('/dashboard/myprofile', 'App\Http\Controllers\DashboardController@myprofile')->name('dashboard.myprofile');
});


require __DIR__.'/auth.php';
