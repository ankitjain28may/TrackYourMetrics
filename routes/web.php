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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/folders', 'FolderController');
Route::post('/folders/{path}', 'FolderController@store');
Route::get('/folders/delete/{id}', 'FolderController@destroy');
Route::get('/files/delete/{id}', 'FolderController@destroyfiles');

Route::post('/files/upload/{path}', 'FolderController@fileupload');

Route::get('/download/files/{path}', 'FolderController@download');
Route::get('/download/folders/{path}', 'FolderController@downloadfolders');
