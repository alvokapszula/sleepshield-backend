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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resources([
    'patients' => 'PatientController',
    'shields' => 'ShieldController',
    'sensors' => 'SensorController',
    'exams' => 'ExamController',
    'examtypes' => 'ExamTypeController',
]);

Route::get('/exams/{exam}/stop', 'ExamController@stop');
Route::get('/exams/{exam}/start', 'ExamController@start');
Route::get('/exams/{exam}/alarms', 'ExamController@alarms');

Route::get('/exams/{exam}/sensors/{sensor}/data', 'SensorController@fulldata');
Route::get('/sensors/{sensor}/data', 'SensorController@livedata');
Route::get('/exams/{exam}/sensors/{sensor}/{time?}', 'SensorController@show_exam');

Route::get('/datatables/exams', 'DataTablesController@exams');
Route::get('/datatables/patients', 'DataTablesController@patients');
Route::get('/datatables/patients/{patient}/exams', 'DataTablesController@patients_exams');
Route::get('/datatables/users/{user}/exams', 'DataTablesController@users_exams');
Route::get('/datatables/shields', 'DataTablesController@shields');
// Route::get('/datatables/shields/{shield}/sensors', 'DataTablesController@shield_sensors');
// Route::get('/datatables/shields/{shield}/exams', 'DataTablesController@shield_exams');
