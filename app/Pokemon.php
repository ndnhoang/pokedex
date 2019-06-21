<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    //
    protected $table = 'pokemons';

    
    
    public function image()
    {
        return $this->belongsTo('App\Image', 'avatar', 'id');
    }

    
    public function types()
    {
        return $this->belongsToMany('App\PokemonType', 'pokemon_pokemon_type', 'pokemon_id', 'type_id');
    }
    
    
    
}
