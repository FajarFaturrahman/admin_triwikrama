<?php

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
    return view('auth/login');
});

Route::get('/portofolio', 'PortofolioController@index')->name('portofolio');

Route::get('/addPortofolio', 'AddPortofolioController@index')->name('addPortofolio');

Route::get('/detailPortofolio', 'DetailPortofolioController@index')->name('detailPortofolio');

Route::get('/product', 'productController@index')->name('product');

Route::get('/client', 'ClientController@index')->name('client');

Route::post('/client', 'ClientController@store')->name('client.store');

Route::get('/inbox', 'InboxController@index')->name('inbox');
Route::get('/inbox/{id}', 'InboxController@show')->name('inbox.show');

Route::get('/home', 'homeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Logout
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
