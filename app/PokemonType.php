<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PokemonType extends Model
{
    //
    protected $table = 'pokemon_types';
    
    public function pokemons()
    {
        return $this->belongsToMany('App\Pokemon', 'pokemon_pokemon_type', 'type_id', 'pokemon_id');
    }
    
}
