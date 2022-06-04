<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', function () {return view('login');});
Route::post('/postLogin', [App\Http\Controllers\LoginController::class, 'postLogin'])->name('postLogin');
Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::group(['middleware'=> ['admin'] ], function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\IndexController::class, 'dashboard'])->name('dashboard');
    Route::get('/booking/{id}', [App\Http\Controllers\Admin\IndexController::class, 'booking'])->name('booking');
    
    // Plans
    Route::group(['prefix'=> 'plans','as' => 'plans.' ], function () {
        Route::get('/', [App\Http\Controllers\Admin\PlansController::class, 'index'])->name('index');
    });
    
    // Subscriptions
    Route::group(['prefix'=> 'subscriptions','as' => 'subscriptions.' ], function () {
        Route::get('/', [App\Http\Controllers\Admin\SubscriptionsController::class, 'index'])->name('index');
    });

    
});