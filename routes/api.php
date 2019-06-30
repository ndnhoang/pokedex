<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Pokemon
Route::get('/pokemons/{count}/{start}', 'API\PokemonController@index')->name('api.pokemon');
Route::get('/pokemons/type/{name}/{count}/{start}', 'API\PokemonController@filterPokemonByType')->name('api.pokemons.type');
Route::get('/pokemon/{slug}', 'API\PokemonController@getPokemon')->name('api.pokemon.detail');
// Pokemon Type
Route::get('/types', 'API\PokemonTypeController@index')->name('api.types');
Route::get('/type/{name}', 'API\PokemonTypeController@getType')->name('api.type');