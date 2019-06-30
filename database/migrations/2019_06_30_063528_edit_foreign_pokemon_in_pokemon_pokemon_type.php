<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditForeignPokemonInPokemonPokemonType extends Migration
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
        });
    }
}
