<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropFogeignFromPokemonPokemonType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pokemon_pokemon_type', function (Blueprint $table) {
            $table->dropForeign(['pokemon_id']);
            $table->foreign('pokemon_id')->references('id')->on('pokemons')->onDelete('cascade');

            $table->dropForeign(['type_id']);
            $table->foreign('type_id')->references('id')->on('pokemon_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pokemon_pokemon_type', function (Blueprint $table) {
            $table->dropForeign(['pokemon_id']);
            $table->foreign('pokemon_id')->references('id')->on('pokemons');

            $table->dropForeign(['type_id']);
            $table->foreign('type_id')->references('id')->on('pokemon_types');
        });
    }
}
