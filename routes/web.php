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
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/createmeeting', 'CreateMeetingController@index')->name('createMeeting');
Route::get('/updatemeeting/{id}', 'CreateMeetingController@update')->name('updateMeeting');
Route::get('/nextmeetings', 'NextMeetingsController@index')->name('nextMeetings');
Route::get('/reportarea', 'ReportAreaController@index')->name('reportArea');
Route::get('/adminarea', 'AdminAreaController@index')->name('adminArea');
Route::get('/reportarea/fetchtable', 'ReportAreaController@fetch_table')->name('reportAreaFetchTable');
Route::post('/adminarea/postemployee', 'AdminAreaController@post_employee')->name('adminAreaPostEmployee');
Route::post('/adminarea/postroom', 'AdminAreaController@post_room')->name('adminAreaPostRoom');
Route::post('/adminarea/insert', 'AdminAreaController@insert_user')->name('adminAreaInsertUser');
Route::post('/adminarea/insertroom', 'AdminAreaController@insert_room')->name('adminAreaInsertRoom');
Route::put('/adminarea/updateroom', 'AdminAreaController@update_room')->name('adminAreaUpdateRoom');
Route::put('/adminarea/updateuser', 'AdminAreaController@update_user')->name('adminAreaUpdateUser');
Route::put('/adminarea/deleteuser', 'AdminAreaController@delete_user')->name('adminAreaDeleteUser');
Route::put('/adminarea/deleteroom', 'AdminAreaController@delete_room')->name('adminAreaDeleteRoom');
Route::post('/createmeeting/insertmeeting', 'CreateMeetingController@insert_meeting')->name('createMeetingInsertMeeting');
Route::put('/createmeeting/updatemeeting/{id}', 'CreateMeetingController@update_meeting')->name('createMeetingUpdateMeeting');
Route::put('/nextmeetings/deletemeeting/{id}', 'NextMeetingsController@delete_meeting')->name('nextMeetingsDeleteMeeting');

Auth::routes();

