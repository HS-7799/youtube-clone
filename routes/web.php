<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/channels/{channel}','ChannelController@show')->name('channels.show');
Route::put('/channels/{channel}','ChannelController@update')->name('channels.update');

Route::get('/videos/{video}','VideoController@show')->name('videos.show');

Route::put('/videos/{video}/views','VideoController@updateViews');

Route::get('/videos/{video}/comments','CommentController@index');
Route::get('/comments/{comment}/replies','CommentController@show');

Route::middleware('auth')->group(function(){

    Route::post('/channels/{channel}/subscription','SubscriptionController@store')->name('subscription');
    Route::get('/channels/{channel}/videos','UploadVideoController@index')->name('videos.upload');
    Route::post('/channels/{channel}/videos','UploadVideoController@store');

    Route::get('/videos/{video}/edit','VideoController@edit')->name('videos.edit');
    Route::put('/videos/{video}','VideoController@update')->name('videos.update');

    Route::post('/videos/{id}/vote','VoteController@store');
    Route::delete('/videos/{id}/vote','VoteController@destroy');

    Route::post('/comments/{video}','CommentController@store');
});
