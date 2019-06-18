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



