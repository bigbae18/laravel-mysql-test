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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('register', 'RegisterController@index')->name('register');
Route::post('register', 'RegisterController@store');
Route::get('login', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@store');
Route::get('logout', 'LoginController@logout')->name('logout');
Route::prefix('users')->group(function() {

    Route::get('/{id}', 'UserController@index')->name('users.index');
    Route::get('/{id}/create', 'UserController@create')->name('users.create');
    Route::post('/{id}/store', 'UserController@store')->name('users.store');
    Route::get('/{id}/edit', 'UserController@edit')->name('users.edit');
    Route::put('/{id}/update', 'UserController@update')->name('users.update');
});
