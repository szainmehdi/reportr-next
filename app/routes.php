<?php
Route::group(['before' => 'auth'], function() {
    Route::get('/', function() {
        $user = Auth::user();
        return View::make('hello')->withUser($user);
    });

});


Route::get('login', function()
{
    return View::make('login');
});

Route::post('login', function()
{
    Auth::attempt([
        'username' => Input::get('username'),
        'password' => Input::get('password')
    ]);

    return Redirect::to('/');
});

Route::get('logout', function() {
    Auth::logout();

    return Redirect::to('login');
});