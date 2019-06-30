<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PokemonType;

class PokemonTypeController extends Controller
{
    public function index(Request $request)
    {
        return PokemonType::select('id', 'name')->get();
    }

    public function getType(Request $request, $name)
    {
        $name = ucfirst($name);
        return PokemonType::select('id', 'name', 'weakness')
            ->where('name', $name)
            ->get()
            ->map(function($type) {
                $weakness = json_decode($type->weakness);
                $type->weakness_0 = PokemonType::select('id', 'name')
                                        ->whereIn('id', $weakness->type_0)
                                        ->get();
                $type->weakness_50 = PokemonType::select('id', 'name')
                                        ->whereIn('id', $weakness->type_50)
                                        ->get();
                $type->weakness_200 = PokemonType::select('id', 'name')
                                        ->whereIn('id', $weakness->type_200)
                                        ->get();
                return $type;
            });
    }
}
