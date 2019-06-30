<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pokemon;
use App\PokemonType;
use Storage;

class PokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $count, $start)
    {
        return Pokemon::whereNull('original')
            ->orderBy('number', 'asc')
            ->take($count)
            ->skip($start - 1)
            ->get()
            ->map(function($pokemon) {
                $pokemon->avatar = $pokemon->image->getUrl($pokemon->avatar);
                $pokemon->types = $pokemon->types;
                return $pokemon;
            });
    }

    public function filterPokemonByType(Request $request, $name, $count, $start)
    {
        $name = ucfirst($name);
        $type = PokemonType::where('name', $name)->first();
        if ($type) {
            return $type->pokemons()
            ->whereNull('original')
            ->orderBy('number', 'asc')
            ->take($count)
            ->skip($start - 1)
            ->get()
            ->map(function($pokemon) {
                $pokemon->avatar = $pokemon->image->getUrl($pokemon->avatar);
                $pokemon->types = $pokemon->types;
                return $pokemon;
            });
        }
        return null;
    }

    public function getPokemon(Request $request, $slug) {
        $pokemon = Pokemon::where('slug', $slug)
            ->take(1)
            ->get()
            ->map(function($pokemon) {
                $pokemon_prev = Pokemon::where('number', '<', $pokemon->number)
                                    ->orderBy('number', 'desc')
                                    ->first();
                $pokemon_next = Pokemon::where('number', '>', $pokemon->number)
                                    ->orderBy('number', 'asc')
                                    ->first();
                $pokemon_form = Pokemon::where('number', '=', $pokemon->number)
                                    ->orderBy('id', 'asc')
                                    ->get();
                
                $pokemon->forms = $pokemon_form;
                $pokemon->next = $pokemon_next;
                $pokemon->prev = $pokemon_prev;
                $pokemon->avatar = $pokemon->image->getUrl($pokemon->avatar);
                $pokemon->types = $pokemon->types;
                $weakness = $weakness_0 = $weakness_50 = $weakness_200 = [];
                foreach ($pokemon->types as $type) {
                    $weakness_type = json_decode($type->weakness);
                    $weakness_0[] = PokemonType::select('id', 'name')
                                            ->whereIn('id', $weakness_type->type_0)
                                            ->get();
                    $weakness_50[] = PokemonType::select('id', 'name')
                                            ->whereIn('id', $weakness_type->type_50)
                                            ->get();
                    $weakness_200[] = PokemonType::select('id', 'name')
                                            ->whereIn('id', $weakness_type->type_200)
                                            ->get();
                }
                $weakness_type_0 = [];
                foreach ($weakness_0 as $value) {
                    foreach ($value as $item) {
                        if (!isset($weakness_type_0[$item->id])) {
                            $weakness_type_0[$item->id] = $item;    
                        }
                    }
                    
                }
                $weakness_type_50 = [];
                foreach ($weakness_50 as $value) {
                    foreach ($value as $item) {
                        if (!isset($weakness_type_50[$item->id])) {
                            $weakness_type_50[$item->id] = $item;    
                        }
                    }
                }
                $weakness_type_200 = [];
                foreach ($weakness_200 as $value) {
                    foreach ($value as $item) {
                        if (!isset($weakness_type_200[$item->id])) {
                            $weakness_type_200[$item->id] = $item;    
                        }
                    }
                    
                }
                foreach ($weakness_type_50 as $value) {
                    foreach ($weakness_type_0 as $value_0) {
                        if ($value_0->id == $value->id) {
                            unset($weakness_type_0[$value_0->id]);
                        }
                    }
                }
                foreach ($weakness_type_200 as $value) {
                    foreach ($weakness_type_0 as $value_0) {
                        if ($value_0->id == $value->id) {
                            unset($weakness_type_0[$value_0->id]);
                        }
                    }
                }
                foreach ($weakness_type_200 as $value) {
                    foreach ($weakness_type_50 as $value_0) {
                        if ($value_0->id == $value->id) {
                            unset($weakness_type_50[$value_0->id]);
                        }
                    }
                }
                $weakness['type_0'] = $weakness_type_0;
                $weakness['type_50'] = $weakness_type_50;
                $weakness['type_200'] = $weakness_type_200;
                $pokemon->weakness = $weakness;
                return $pokemon;
            });
        return $pokemon;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pokemon.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'number' => 'required|unique:pokemons',
            'name'   => 'required|unique:pokemons',
            'avatar' => 'required|image|mimes:jpeg,jpg,png',
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        if ($request->hasFile('avatar')) {
            DB::beginTransaction();
            try {
                $avatar = new Image;
                $extension = $request->avatar->extension();
                $avatar->url = $request->avatar->storeAs('public/images/pokemon', $request->number.'.'.$extension);
                $avatar->table = 'pokemons';
                $avatar->meta = 'avatar';

                $avatar->save();

                $pokemon = new Pokemon();
                $pokemon->number = $request->number;
                $pokemon->name = $request->name;
                $pokemon->avatar = $avatar->id;
                $pokemon->save();

                $avatar->value = $pokemon->id;
                $avatar->save();
                DB::commit();
                
                Alert::success('Success', 'You have successfully added the pokemon.');
                
                return redirect()->back();
                
            } catch (Exception $e) {
                DB::rollback();
                Alert::error('Error', 'Added pokemon failed, please try again.');
                return redirect()->back()->withInput();
                
            }
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $pokemon = Pokemon::find($id);
        if ($pokemon) {
            return view('pokemon.edit', compact(['pokemon']));
        } else {
            
            Alert::error('Error', 'No pokemon found.');
            
            return redirect()->back();
            
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pokemon = Pokemon::find($id);
        if ($pokemon) {
            $data = $request->all();
            $rules = [
                'number' => 'required|unique:pokemons,number,'.$id,
                'name'   => 'required|unique:pokemons,name,'.$id,
                'avatar' => 'image|mimes:jpeg,jpg,png',
            ];
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
           
            DB::beginTransaction();
            try {
                $avatar = Image::find($pokemon->avatar);

                $pokemon->number = $request->number;
                $pokemon->name = $request->name;

                if ($request->hasFile('avatar')) {
                    if ($avatar) {
                        $extension = $request->avatar->extension();
                        $avatar->url = $request->avatar->storeAs('public/images/pokemon', $request->number.'.'.$extension);
                    } else {
                        $avatar = new Image();
                        $extension = $request->avatar->extension();
                        $avatar->url = $request->avatar->storeAs('public/images/pokemon', $request->number.'.'.$extension);
                        $avatar->table = 'pokemons';
                        $avatar->meta = 'avatar';
                    }
    
                    $avatar->save();
                    $pokemon->avatar = $avatar->id;
                }
                
                $pokemon->save();
                if ($request->hasFile('avatar')) {
                    $avatar->value = $pokemon->id;
                    $avatar->save();
                }
                
                DB::commit();
                
                Alert::success('Success', 'You have successfully updated the pokemon.');
                
                return redirect()->back();
                
            } catch (Exception $e) {
                DB::rollback();
                Alert::error('Error', 'Updated pokemon failed, please try again.');
                return redirect()->back()->withInput();
                
            }
            
        } else {
            
            Alert::error('Error', 'No pokemon found.');
            
            return redirect()->route('pokemons');
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->ids;
        if ($ids == '') {
            
            Alert::warning('Warning', 'You have not selected any pokemon.');
            
            return redirect()->back();
            
        }
        DB::beginTransaction();
        try {
            $ids = explode(',', $ids);
            Pokemon::whereIn('id', $ids)->delete();
            DB::commit();
            
            Alert::success('Success', 'You have successfully deleted the pokemon.');
            
            return redirect()->back();
            
            
        } catch (Exception $e) {
            DB::rollback();
            
            Alert::error('Error', 'Deleted pokemon failed, please try again.');

            return redirect()->back();
            
        }
    }
}
