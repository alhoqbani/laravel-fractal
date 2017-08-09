<?php

Route::get('auth/laravel-api/redirect', 'Auth\OAuth\LaravelApiAuthController@redirect')->name('laravel.api.redirect');
Route::get('auth/laravel-api/callback', 'Auth\OAuth\LaravelApiAuthController@callback')->name('laravel.api.callback');

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
