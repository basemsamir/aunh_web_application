<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index')->name('ris.home');
Route::post('/create', 'HomeController@store')->name('ris.store');
Route::get('/{vid}/edit', 'HomeController@edit')->name('ris.edit');
Route::patch('/{vid}/edit', 'HomeController@update')->name('ris.update');
Route::post('ajax/getProcedures','HomeController@ajaxMDeviceProcedures');
Route::post('ajax/postProcDevice','HomeController@ajaxStoreDeviceProc');
Route::post('ajax/deleteProcDevice','HomeController@ajaxDeleteDeviceProc');
Route::post('ajax/getPatientsToday','HomeController@ajaxGetAllPatientsToday');

Route::auth();

//Login Routes...
Route::get('/admin/login','AdminAuth\AuthController@showLoginForm');
Route::post('/admin/login','AdminAuth\AuthController@login');
Route::get('/admin/logout','AdminAuth\AuthController@logout');

// Registration Routes...
Route::get('admin/register', 'AdminAuth\AuthController@showRegistrationForm');
Route::post('admin/register', 'AdminAuth\AuthController@register');

Route::get('/admin', 'AdminController@index');





//Route::get('/home', 'HomeController@index');
