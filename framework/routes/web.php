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
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
Route::post('login', 'Auth\LoginController@login');

Route::get('home', 'HomeController@index')->name('home');

Route::resource('data_user', 'UsersController');
Route::resource('sdm', 'SdmController');

Route::group(['prefix' => 'permohonan', 'middleware' => 'auth', 'as' => 'permohonan.'], function(){
	Route::resource('/', 'PermohonanController');
	Route::post('updatePratinjau', 'PermohonanController@updatePratinjau');
	Route::post('updateCatatan', 'PermohonanController@updateCatatan');

	Route::get('surat', 'PermohonanController@surat');
	Route::get('downloadPDF', 'PermohonanController@downloadPDF');
	Route::get('terima/{id}', 'PermohonanController@terima');
	Route::post('tolak', 'PermohonanController@tolak');
});

Route::resource('mahasiswa', 'MahasiswaController');
Route::get('home-mahasiswa', 'MahasiswaController@homeMahasiswa')->name('home-mahasiswa');

Route::get('/data_prasyarat', function () {
    return view('admin/data_prasyarat');
});
Route::get('/update_profil', function () {
    return view('admin/update_profil');
});

Route::get('/update_data_prasyarat', function () {
    return view('admin/update_data_prasyarat');
});
