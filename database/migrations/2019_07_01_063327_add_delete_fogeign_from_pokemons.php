<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeleteFogeignFromPokemons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pokemons', function (Blueprint $table) {
            $table->dropForeign(['avatar']);
            $table->foreign('avatar')->references('id')->on('images')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pokemons', function (Blueprint $table) {
            $table->dropForeign(['avatar']);
            $table->foreign('avatar')->references('id')->on('images');
        });
    }
}
