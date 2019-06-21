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

Route::get('/', 'HomeController@index')->name('home');

// Pokemon
Route::get('/pokemon', 'PokemonController@index')->name('pokemons');
Route::get('/pokemon/add', 'PokemonController@create')->name('pokemon.add');
Route::post('/pokemon/add', 'PokemonController@store')->name('pokemon.add');
Route::get('/pokemon/edit/{id}', 'PokemonController@edit')->name('pokemon.edit');
Route::post('/pokemon/edit/{id}', 'PokemonController@update')->name('pokemon.edit');
Route::post('/pokemon/delete', 'PokemonController@destroy')->name('pokemon.delete');

// Pokemon Type
Route::get('/type', 'PokemonTypeController@index')->name('types');
Route::get('/type/add', 'PokemonTypeController@create')->name('type.add');
Route::post('/type/add', 'PokemonTypeController@store')->name('type.add');
Route::get('/type/edit/{id}', 'PokemonTypeController@edit')->name('type.edit');
Route::post('/type/edit/{id}', 'PokemonTypeController@update')->name('type.edit');



