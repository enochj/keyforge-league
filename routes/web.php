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
Route::get('/', 'PlayerController@index')->name('player');
Route::get('/add', 'DeckController@create')->name('create-deck');

Route::resources([
    'leagues' => 'LeagueController',
    'decks' => 'DeckController'
]);
