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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
Route::post('login', 'Auth\LoginController@login');

Route::get('/', 'HomeController@index')->name('home');
Route::get('getDataPermohonan', 'HomeController@getDataPermohonan');

Route::group(['prefix' => 'permohonan', 'middleware' => 'auth', 'as' => 'permohonan.'], function(){
	Route::resource('/', 'PermohonanController');
	Route::post('updatePratinjau', 'PermohonanController@updatePratinjau');
	Route::post('updateCatatan', 'PermohonanController@updateCatatan');

	Route::get('surat', 'PermohonanController@surat');
	Route::get('downloadPDF', 'PermohonanController@downloadPDF');
	Route::get('terima/{id}', 'PermohonanController@terima');
	Route::post('tolak', 'PermohonanController@tolak');

	Route::get('ak02Check', 'PermohonanController@ak02Check');
});

Route::group(['prefix' => 'users', 'middleware' => 'auth', 'as' => 'users.'], function(){
	Route::resource('/', 'UserController');
	Route::get('edit/{id}', 'UserController@edit');
	Route::post('update', 'UserController@update');
	Route::post('destroy', 'UserController@destroy');

	Route::get('kelola-profil/{id}', 'UserController@kelolaProfil');
	Route::post('kelolaProfilSubmit', 'UserController@kelolaProfilSubmit');
});

Route::group(['prefix' => 'prodi', 'middleware' => 'auth', 'as' => 'prodi.'], function(){
	Route::resource('/', 'ProdiController');
	Route::get('edit/{id}', 'ProdiController@edit');
	Route::post('update', 'ProdiController@update');
	Route::post('destroy', 'ProdiController@destroy');
});

Route::group(['prefix' => 'report', 'middleware' => 'auth', 'as' => 'report.'], function(){
	Route::get('/', 'ReportController@index');
	Route::get('fetchData', 'ReportController@fetchData');
	Route::get('exportData', 'ReportController@exportData');
});