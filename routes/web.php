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

use App\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/add', function () {
    return User::find(3)->addFriend(1);
});

Route::get('/accept', function () {
    return User::find(1)->acceptFriend(4);
});

Route::get('/friends', function () {
    return User::find(1)->friends();
});

Route::get('/pending', function () {
    return User::find(1)->pendingFriendRequests();
});

Route::get('/ids', function () {
    return User::find(1)->friendsIds();
});

Route::get('/ch', function () {
    return User::find(5)->addFriend(3);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile/{slug}', [
        'uses' => 'ProfileController@index',
        'as' => 'profile'
    ]);

    Route::get('/profile/edit/profile', [
        'uses' => 'ProfileController@edit',
        'as' => 'profile.edit'
    ]);

    Route::post('/profile/update/profile', [
        'uses' => 'ProfileController@update',
        'as' => 'profile.update'
    ]);
});

//Route::get('/test', 'ProfileController@test');
