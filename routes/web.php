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

// Route::get('/', function () {
//     return view('player.index');
// });
Route::get('/', 'PlayerController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/player', 'PlayerController@index')->name('player');
Route::get('/add', 'DeckController@create')->name('create-deck');
Route::get('/decks/find-decks', 'DeckController@findDecks')
    ->name('find-decks');
Route::get('/leagues/find-leagues', 'LeagueController@findLeagues')
    ->name('find-leagues');
Route::post('/leagues/join-league', 'LeagueController@joinLeague')
    ->name('join-league');
Route::get('/leagues/{id}/decks', 'LeagueController@decks')->name('league-decks');
Route::delete('/leagues/decks', 'LeagueController@removeDeck')->name('league-decks-delete');

Route::resources([
    'leagues' => 'LeagueController',
    'decks' => 'DeckController'
]);
