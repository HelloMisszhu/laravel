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
Route::get('index/index','IndexController@index')->name('index/index');
Route::resource('test/index','TestController');
Route::post('test/store','TestController@store')->name('test/store');
Route::get('test/index','TestController@index')->name('test/index');
Route::delete('test/destroy/{id}','TestController@destroy')->name('test/destroy');
Route::put('test/update','TestController@update')->name('test/update');
Route::any('test/dition','TestController@dition')->name('test/dition');

Route::resource('user/index','UserController');
Route::get('user/login','UserController@login')->name('user/login');
Route::get('user/add','UserController@add')->name('user/add');
Route::get('user/loginOut','UserController@loginOut')->name('user/loginOut');
Route::post('user/order','UserController@order')->name('user/order');
Route::get('mail/send','MailController@send')->name('mail/send');

Route::get('student/search','StudentController@search')->name('student/search');


Route::resource('product','ProductController');
Route::post('product/store','ProductController@store')->name('product/store');
Route::post('product/add','ProductController@add')->name('product/add');
Route::post('product/update','ProductController@update')->name('product/update');
Route::post('product/search','ProductController@search')->name('product/search');
Route::delete('product/destroy/{id}','ProductController@destroy')->name('product/destroy');







