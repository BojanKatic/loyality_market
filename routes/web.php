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

Route::group(['middleware' => 'auth'], function () {

    //Home routes
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/search','HomeController@search');

    // User routes
    Route::resource('user', 'UserController');
 

    // Project routes
    Route::resource('projects', 'ProjectController');

    //Clients routes
    Route::resource('clients', 'ClientsController');

    Route::any('/client/finish-order', 'ClientsController@finishInvoice');
    Route::post('/client/racun', 'ClientsController@racunKOntrola'); 
    Route::get('client-invoice/{client}', 'ClientsController@invoice');
    Route::get('show-invoice/{invoice}', 'ClientsController@showInvoice');


    //Resource routes
    Route::resource('resources', 'ResourcesController');
    Route::patch('/resources/{resource}/sumUpdate','ResourcesController@updateSum');
    Route::post('/resources/ajax','ResourcesController@ajax');
    Route::get('/cart/{id}', 'ResourcesController@cart');
    Route::post('resources/reset_cart', 'ResourcesController@cart_reset');

    //Newsletter routes
    Route::resource('newsletter', 'NewsletterController');

    //Project task routes
    Route::post('/projects/{project}/task', 'ProjectTasksController@store');
    Route::patch('/tasks/{task}', 'ProjectTasksController@update');
});
Auth::routes();

