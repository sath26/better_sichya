<?php

 Route::get('/home', 'HomeController@index');

Route::get('/', 'HomeController@index');

Auth::routes();
Route::get('tag/{slug}', [
	'uses' => 'TagController@tag',
	'as' => 'tag'
	]);
Route::resource('/tags', 'TagController');
Route::resource('/thread','ThreadController');
Route::resource('/note','NoteController');
Route::resource('comment','CommentController',['only'=>['update','destroy']]);
 


Route::post('/thread/mark-as-solution','ThreadController@markAsSolution')->name('markAsSolution');
Route::post('comment/create/{thread}','CommentController@addThreadComment')->name('threadcomment.store');
Route::post('comment/like','LikeController@toggleLike')->name('toggleLike');
Route::post('reply/create/{comment}','CommentController@addReplyComment')->name('replycomment.store');
Route::get('/user/profile/{user}', 'UserProfileController@index')->name('user_profile')->middleware('auth');
Route::get('/markAsRead',function(){
	auth()->user()->unreadNotifications->markAsRead();
});
Route::get('/test', function(){
	$user = App\User::find(1);
	$notifications=$user->unreadNotifications;
	foreach ($notifications as $notification) {
		dd($notification->data,$notification->data['post']['title']);
	}
});
Route::get('{provider}/auth', [
	'uses' => 'SocialsController@auth',
	'as' => 'social.auth'
	]);
Route::get('/{provider}/redirect', [
	'uses' => 'SocialsController@auth_callback',
	'as' => 'social.callback'
	]);
