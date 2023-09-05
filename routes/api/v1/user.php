<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/**
 * Start Helper EndPoints
 */
Route::namespace('Helper')->group(function () {
    Route::get('countries', 'CountryController@index');
    Route::get('parcel_categories', 'ParcelCategoryController@index');
    Route::get('packages', 'PackageController@index');
});

/**
 * End Helper EndPoints
 */

/**
 * Start Authentication EndPoints
 */
Route::namespace('Auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('complete_data', 'AuthController@complete_data')->middleware('auth:user');
    Route::post('send_otp', 'AuthController@send_otp');
    Route::post('verify_phone', 'AuthController@verify_phone');
    Route::post('login', 'AuthController@login');
    Route::post('login_with_otp', 'AuthController@login_with_otp');
    Route::post('forget_password', 'AuthController@forget_password');
    Route::post('update_password', 'AuthController@update_password');
});
/**
 * End Authentication EndPoints
 */

 /**
 * Start User EndPoints
 */
Route::namespace('User')->middleware('auth:user')->group(function () {
    Route::get('profile', 'UserController@profile');
    Route::post('update_profile', 'UserController@update_profile');
    Route::post('change_password', 'UserController@change_password');
});
/**
 * End User EndPoints
 */


  /**
 * Start Address EndPoints
 */
Route::namespace('Address')->middleware('auth:user')->group(function () {
    Route::apiResource('addresses', 'AddressController');
});
/**
 * End Address EndPoints
 */


   /**
 * Start Order EndPoints
 */
Route::namespace('Order')->middleware('auth:user')->group(function () {
    Route::apiResource('orders', 'OrderController')->except('update');
    Route::post('orders/{id}/cancel', 'OrderController@cancel');
});
/**
 * End Order EndPoints
 */
