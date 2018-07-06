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
    return view('home');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logout', 'Auth\LogoutController@_index_');

Route::get('/manageusers', 'Auth\UserManagerController@_index_');
Route::get('/manageusers/edit/{id}', 'Auth\UserManagerController@_edit_');
Route::get('/manageusers/addnew', 'Auth\UserManagerController@_new_');
Route::post('/manageusers', 'Auth\UserManagerController@_action_');

Route::get('/khayer', 'Manage\khayerController@_index_');
Route::get('/khayer/edit/{id}', 'Manage\khayerController@_edit_');
Route::get('/khayer/addnew', 'Manage\khayerController@_new_');
Route::post('/khayer', 'Manage\khayerController@_action_');

Route::get('/niazmandan', 'Manage\niazmandanController@_index_');
Route::get('/niazmandan/edit/{id}', 'Manage\niazmandanController@_edit_');
Route::get('/niazmandan/addnew', 'Manage\niazmandanController@_new_');
Route::get('/niazmandan/takafol/{id}', 'Manage\niazmandanController@_takafol_');
Route::get('/niazmandan/takafol/{id}/adddew', 'Manage\niazmandanController@_takafol_new_');
Route::get('/niazmandan/takafol/{id}/edit/{t_id}', 'Manage\niazmandanController@_takafol_edit_');
Route::post('/niazmandan', 'Manage\niazmandanController@_action_');
Route::post('/niazmandan/getdata', 'Manage\niazmandanController@_niaz_getdata');
Route::post('/niazmandan/takafol/getdata', 'Manage\niazmandanController@_niaz_takafol_getdata');
Route::post('/niazmandan/takafol/{id}', 'Manage\niazmandanController@_takafol_action_');

Route::get('/groups', 'Auth\groupcontroller@_index_');
Route::post('/groups', 'Auth\groupcontroller@_action_');
Route::post('/groups/getdata', 'Auth\groupcontroller@get_data');

Route::get('/managegroups', 'Auth\GroupManagementController@_index_');
Route::post('/managegroups/savedata', 'Auth\GroupManagementController@save_data');
Route::post('/managegroups/updateroles', 'Auth\GroupManagementController@update_roles');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
