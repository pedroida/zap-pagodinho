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

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'ChatsController@index')->name('home');
    Route::get('/', 'ChatsController@index');
    Route::get('/chats', 'ChatsController@index')->name('chats');

    Route::get('friends', 'FriendsController@index')->name('friends.index');

    Route::group(['as' => 'ajax.'], function () {

        Route::group(['prefix' => 'chats'], function () {
           Route::post('store', 'ChatsController@store')->name('chat.store');

           Route::delete('delete/{chat_id}', 'ChatsController@destroy')->name('chat.destroy');

           Route::post('leave/{chat_id}', 'ChatsController@leave')->name('chat.leave');

           Route::get('new-chats-available', 'ChatsController@newChatsAvailable')->name('chats.available');

           Route::get('my-chats', 'ChatsController@myChats')->name('my-chats');

           Route::post('send-message', 'MessageController@sendMessage')->name('message.send');
        });

        Route::get('available-new-friends', 'FriendsController@availableNewFriends')
            ->name('available-new-friends');

        Route::post('send-invite/{user_id}', 'FriendsController@sendFriendshipInvite')
            ->name('send.friendship-invite');

        Route::get('notifications/invites', 'NotificationsController@getInvites')
            ->name('notifications.invites');
        Route::get('notifications/messages', 'NotificationsController@getMessages')
            ->name('notifications.messages');

        Route::post('invite/{id}/accept', 'FriendsController@acceptInvite')->name('invite.accept');
        Route::post('invite/{id}/decline', 'FriendsController@declineInvite')
            ->name('invite.decline');
    });

	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

