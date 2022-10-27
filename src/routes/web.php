<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Master Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'Auth\LoginController@showLoginForm');

Route::middleware(['auth'])->group(function() {
    Route::post('create-tenant', 'MasterController@createTenant');
});
