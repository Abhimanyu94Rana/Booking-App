<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//API route for register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login'])->name('api.login');

// For non authenticated users
Route::any('/non_authenticated', function(Request $request) {        
    return response()->json(['status'=>false,'message' => 'User is not authenticated.'],400);       
})->name('non_authenticated');

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', [App\Http\Controllers\API\Customer\IndexController::class, 'profile']);
    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);

    // Booking Module
    Route::group([ 'prefix' => 'booking','as' => 'booking.'], function () {         
        Route::get('/list', [App\Http\Controllers\API\Customer\Booking\IndexController::class, 'list'])->name('list');
        Route::post('/store', [App\Http\Controllers\API\Customer\Booking\IndexController::class, 'store'])->name('store');
    });
});

// Paypal Integration

Route::post('paypal', [App\Http\Controllers\API\Customer\PaypalController::class,'postPaymentWithpaypal'])->name('paypal');
// Route::get('paywithpaypal', array('as' => 'paywithpaypal','uses' => 'PaypalController@payWithPaypal',));
// Route::post('paypal', array('as' => 'paypal','uses' => 'PaypalController@postPaymentWithpaypal',));
// Route::get('paypal', array('as' => 'status','uses' => 'PaypalController@getPaymentStatus',));