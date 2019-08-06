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

Route::get('/pokemon-form', 'PokemonController@indexForm')->name('pokemon.forms');
Route::get('/pokemon/add-form', 'PokemonController@createForm')->name('pokemon.form.add');
Route::post('/pokemon/add-form', 'PokemonController@storeForm')->name('pokemon.form.add');
Route::get('/pokemon/edit-form/{id}', 'PokemonController@editForm')->name('pokemon.form.edit');
Route::post('/pokemon/edit-form/{id}', 'PokemonController@updateForm')->name('pokemon.form.edit');

// Pokemon Type
Route::get('/type', 'PokemonTypeController@index')->name('types');
Route::get('/type/add', 'PokemonTypeController@create')->name('type.add');
Route::post('/type/add', 'PokemonTypeController@store')->name('type.add');
Route::get('/type/edit/{id}', 'PokemonTypeController@edit')->name('type.edit');
Route::post('/type/edit/{id}', 'PokemonTypeController@update')->name('type.edit');
Route::post('/type/delete', 'PokemonTypeController@destroy')->name('type.delete');

// Pokemon Statistic
Route::get('/statistics', 'StatisticController@index')->name('statistics');
Route::post('/statistic/edit/{id}', 'StatisticController@update')->name('statistic.edit');
Route::post('/statistic/delete', 'StatisticController@destroy')->name('statistic.delete');

// Species
Route::get('/species', 'SpeciesController@index')->name('species');
Route::get('/species/add', 'SpeciesController@create')->name('species.add');
Route::post('/species/add', 'SpeciesController@store')->name('species.add');
Route::get('/species/edit/{id}', 'SpeciesController@edit')->name('species.edit');
Route::post('/species/edit/{id}', 'SpeciesController@update')->name('species.edit');
Route::post('/species/delete', 'SpeciesController@destroy')->name('species.delete');

// Egg Group
Route::get('/egg-groups', 'EggGroupsController@index')->name('egg_groups');
Route::get('/egg-group/add', 'EggGroupsController@create')->name('egg_group.add');
Route::post('/egg-group/add', 'EggGroupsController@store')->name('egg_group.add');
Route::get('/egg-group/edit/{id}', 'EggGroupsController@edit')->name('egg_group.edit');
Route::post('/egg-group/edit/{id}', 'EggGroupsController@update')->name('egg_group.edit');
Route::post('/egg-group/delete', 'EggGroupsController@destroy')->name('egg_group.delete');

// Color
Route::get('/colors', 'ColorsController@index')->name('colors');
Route::get('/color/add', 'ColorsController@create')->name('color.add');
Route::post('/color/add', 'ColorsController@store')->name('color.add');
Route::get('/color/edit/{id}', 'ColorsController@edit')->name('color.edit');
Route::post('/color/edit/{id}', 'ColorsController@update')->name('color.edit');
Route::post('/color/delete', 'ColorsController@destroy')->name('color.delete');

// Ability
Route::get('/ability/add', 'AbilitiesController@create')->name('ability.add');
Route::post('/ability/add', 'AbilitiesController@store')->name('ability.add');

