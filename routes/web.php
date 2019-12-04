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

// portofolio
Route::get('/portofolio', 'PortofolioController@index')->name('portofolio');
Route::get('/portofolio/create', 'PortofolioController@create');
Route::get('/portofolio/{id}/detailPortofolio', 'PortofolioController@show');
Route::post('/portofolio', 'PortofolioController@store');
Route::get('/portofolio/{id}/edit', 'PortofolioController@edit');
Route::patch('/portofolio/{id}', 'PortofolioController@update');
Route::delete('/portofolio/delete/image/{id}', 'PortofolioController@delete_image')->name('delete_image_portofolio');
Route::delete('/portofolio/delete/image2/{id}', 'PortofolioController@delete_image2')->name('delete_image_portofolio2');
Route::delete('/portofolio/{id}', 'PortofolioController@destroy');


// product
Route::resource('product', 'ProductController');
Route::post('product/update', 'ProductController@update')->name('product.update');
Route::delete('product/delete/{id}', 'ProductController@destroyImage')->name('product.delete');

// client
Route::resource('client', 'ClientController');
Route::post('client/update', 'ClientController@update')->name('client.update');
Route::get('/portofolio/{id}/portofolio', 'ClientController@showPortofolio');
// Route::get('client/destroy/{id}', 'ClientController@destroy');

// inbox
Route::resource('/inbox', 'InboxController');
Route::post('inbox/update', 'InboxController@update')->name('inbox.update');
Route::post('/inbox/filter/{status}', 'InboxController@filter')->name('inbox.filter');
// home
Route::get('/home', 'homeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Logout
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
