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
//Reservation Routes
Route::get('/', 'HomeController@index')->name('ris.home');

Route::post('/create', 'HomeController@store')->name('ris.store');
Route::get('/{vid}/edit', 'HomeController@edit')->name('ris.edit');
Route::patch('/{vid}/edit', 'HomeController@update')->name('ris.update');
Route::get('/show/{id}', 'HomeController@show')->name('ris.show');
Route::post('ajax/getProcedures','HomeController@ajaxMDeviceProcedures');
Route::post('ajax/postProcDevice','HomeController@ajaxStoreDeviceProc');
Route::post('ajax/deleteProcDevice','HomeController@ajaxDeleteDeviceProc');
Route::post('ajax/getPatientsToday','HomeController@ajaxGetAllPatientsToday');

Route::get('patients_proc', 'HomeController@searchPatientProc')->name('ris.patient_proc_search');
Route::post('patients_proc', 'HomeController@postSearchPatientProc')->name('ris.patient_proc_search');

Route::get('patients', 'HomeController@searchPatient')->name('ris.patient.show');
Route::post('patients', 'HomeController@postSearchPatient')->name('ris.patient.search');
Route::get('patients/registration', 'HomeController@create_patient')->name('ris.patient');
Route::post('patients/registration', 'HomeController@store_patient')->name('ris.patient.store');
Route::get('patients/{patient}/edit', 'HomeController@edit_patient')->name('ris.patient.edit');
Route::patch('patients/{patient}', 'HomeController@update_patient')->name('ris.patient.update');

//Login Routes...
Route::auth();

//Admin Login Routes...
Route::get('/admin/login','AdminAuth\AuthController@showLoginForm');
Route::post('/admin/login','AdminAuth\AuthController@login');
Route::get('/admin/logout','AdminAuth\AuthController@logout');

//Admin Routes...
Route::get('/admin', 'AdminController@index');
Route::get('ajax/getNumberOfReservationsPerDeviceToday', 'AdminController@getStatisticsToday');
Route::get('admin/reservation_place','AdminController@res_index');
Route::get('admin/department','AdminController@dep_index');
Route::get('admin/doctor','AdminController@doctor_index');
Route::get('admin/medical_device','AdminController@medical_device_index');
Route::get('admin/procedure','AdminController@procedure_index');
Route::get('admin/user','AdminController@user_index');
Route::get('admin/reservation_user','AdminController@res_user_index');
Route::get('admin/device_proc','AdminController@device_proc_index');
Route::get('admin/wsconfig','AdminController@wsconfig_index');
Route::resource('admin/reservation_place','ReservationPlacesController', array('except'=>['index','show']));
Route::resource('admin/department','DepartmentsController', array('except'=>['index','show']));
Route::resource('admin/doctor','DoctorsController', array('except'=>['index','show']));
Route::resource('admin/medical_device','MedicalDevicesController', array('except'=>['index','show']));
Route::post('admin/api/medical_device_types','MedicalDevicesController@getMedicalDeviceTypesApi')->name('api.medical_device_types');
Route::resource('admin/procedure','ProceduresController', array('except'=>['index','show']));
Route::resource('admin/user','UsersController', array('except'=>['index','show']));
Route::resource('admin/reservation_user','ReservationPlaceUsersController', array('except'=>['index','show','update','edit']));
Route::resource('admin/device_proc','MedicalDeviceProceduresController', array('except'=>['index','show','update','edit']));
Route::resource('admin/wsconfig','WsConfigController', array('except'=>['index','show']));
//Route::get('/home', 'HomeController@index');

Route::get('error_log', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('tran_log', 'AdminController@transactionLog');
