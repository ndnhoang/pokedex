<?php

namespace App\Http\Controllers;

use App\Pokemon;
use App\Image;
use Illuminate\Http\Request;
use Validator;
use DB;
use DataTables;
use Storage;
use Alert;
use App\PokemonType;
use App\Statistic;

class PokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pokemons = Pokemon::whereNull('original');
            return DataTables::of($pokemons)
                ->addColumn('checkbox', function ($pokemon) {
                    return '<div class="custom-control custom-checkbox"><input type="checkbox" value="'.$pokemon->id.'" id="check-'.$pokemon->number.'" class="custom-control-input"><label class="custom-control-label" for="check-'.$pokemon->number.'"></label></div>';
                })
                ->addColumn('number', function($pokemon) {
                    return '<a href="'.route('pokemon.edit', ['id' => $pokemon->id]).'">#'.$pokemon->number.'</a>';
                })
                ->addColumn('pokemon_avatar', function ($pokemon) {
                    return '<img src="'.$pokemon->image->getUrl($pokemon->avatar).'" alt="'.$pokemon->name.'" />';
                })
                ->addColumn('name', function ($pokemon) {
                    return '<a href="'.route('pokemon.edit', ['id' => $pokemon->id]).'">'.$pokemon->name.'</a>';
                })
                ->addColumn('pokemon_type', function($pokemon) {
                    $type_text = '';
                    if ($pokemon->types) {
                        foreach ($pokemon->types as $type) {
                            $type_text .= '<span class="btn-type select2-selection__choice" title="'.$type->name.'">'.$type->name.'</span>';
                        }
                    }
                    return $type_text;
                })
                ->rawColumns(['checkbox', 'number', 'pokemon_avatar', 'name', 'pokemon_type'])
                ->orderColumns(['number', 'name'], ':column $1')
                ->make(true);
        }
        return view('pokemon.list');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexForm(Request $request)
    {
        if ($request->ajax()) {
            $pokemons = Pokemon::whereNotNull('original');
            return DataTables::of($pokemons)
                ->addColumn('checkbox', function ($pokemon) {
                    return '<div class="custom-control custom-checkbox"><input type="checkbox" value="'.$pokemon->id.'" id="check-'.$pokemon->id.'" class="custom-control-input"><label class="custom-control-label" for="check-'.$pokemon->id.'"></label></div>';
                })
                ->addColumn('number', function($pokemon) {
                    $original_pokemon = Pokemon::find($pokemon->original);
                    return '#'.$original_pokemon->number;
                })
                ->addColumn('pokemon_avatar', function ($pokemon) {
                    return '<img src="'.$pokemon->image->getUrl($pokemon->avatar).'" alt="'.$pokemon->name.'" />';
                })
                ->addColumn('name', function ($pokemon) {
                    return '<a href="'.route('pokemon.form.edit', ['id' => $pokemon->id]).'">'.$pokemon->name.'</a>';
                })
                ->addColumn('pokemon_type', function($pokemon) {
                    $type_text = '';
                    if ($pokemon->types) {
                        foreach ($pokemon->types as $type) {
                            $type_text .= '<span class="btn-type select2-selection__choice" title="'.$type->name.'">'.$type->name.'</span>';
                        }
                    }
                    return $type_text;
                })
                ->addColumn('pokemon_original', function($pokemon) {
                    $original_pokemon = Pokemon::find($pokemon->original);
                    return $original_pokemon->name;
                })
                ->rawColumns(['checkbox', 'number', 'pokemon_avatar', 'name', 'pokemon_type', 'pokemon_original'])
                ->orderColumns(['number', 'name'], ':column $1')
                ->make(true);
        }
        return view('pokemon.list-form');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = PokemonType::all();
        return view('pokemon.add', compact(['types']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForm()
    {
        $pokemons = Pokemon::whereNull('original')
            ->orderBy('number', 'asc')
            ->get();
        $types = PokemonType::all();
        return view('pokemon.add-form', compact(['pokemons', 'types']));
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
            'type'   => 'required',
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
                $pokemon->slug = str_slug($request->name);
                $pokemon->avatar = $avatar->id;
                $pokemon->save();

                if ($request->type != NULL) {
                    $pokemon->types()->sync($request->type);
                }

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

    public function storeForm(Request $request)
    {
        $data = $request->all();
        $rules = [
            'original_pokemon' => 'required',
            'name'   => 'required|unique:pokemons',
            'avatar' => 'required|image|mimes:jpeg,jpg,png',
            'type'   => 'required',
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
                $slug = str_slug($request->name);
                $avatar->url = $request->avatar->storeAs('public/images/pokemon', $slug.'.'.$extension);
                $avatar->table = 'pokemons';
                $avatar->meta = 'avatar';

                $avatar->save();

                $origin_pokemon = Pokemon::find($request->original_pokemon);
                $pokemon = new Pokemon();
                $pokemon->number = $origin_pokemon->number;
                $pokemon->name = $request->name;
                $pokemon->slug = $slug;
                $pokemon->avatar = $avatar->id;
                $pokemon->pokemon()->associate($origin_pokemon);
                $pokemon->save();

                if ($request->type != NULL) {
                    $pokemon->types()->sync($request->type);
                }

                $avatar->value = $pokemon->id;
                $avatar->save();
                DB::commit();
                
                Alert::success('Success', 'You have successfully added the pokemon form.');
                
                return redirect()->back();
                
            } catch (Exception $e) {
                DB::rollback();
                Alert::error('Error', 'Added pokemon form failed, please try again.');
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
        $pokemon = Pokemon::where('id', $id)
            ->whereNull('original')
            ->first();
        if ($pokemon) {
            $pokemon_type = [];
            foreach ($pokemon->types as $type) {
                $pokemon_type[] = $type->id;
            }
            $types = PokemonType::all();
            $pokemon_prev = Pokemon::where('number', '<', $pokemon->number)
                            ->whereNull('original')
                            ->orderBy('number', 'desc')
                            ->first();
            $pokemon_prev = $pokemon_prev ? $pokemon_prev->id : null;
            $pokemon_next = Pokemon::where('number', '>', $pokemon->number)
                            ->whereNull('original')
                            ->orderBy('number', 'asc')
                            ->first();
            $pokemon_next = $pokemon_next ? $pokemon_next->id : null;
            $statistic = Statistic::where('pokemon_id', $id)->first();
            return view('pokemon.edit', compact(['pokemon', 'types', 'pokemon_type', 'pokemon_prev', 'pokemon_next', 'statistic']));
        } else {
            
            Alert::error('Error', 'No pokemon found.');
            
            return redirect()->back();
            
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request, $id)
    {
        $pokemon = Pokemon::where('id', $id)
            ->whereNotNull('original')
            ->first();
        if ($pokemon) {
            $pokemons = Pokemon::whereNull('original')
                ->orderBy('number', 'asc')
                ->get();
            $pokemon_type = [];
            foreach ($pokemon->types as $type) {
                $pokemon_type[] = $type->id;
            }
            $types = PokemonType::all();
            $pokemon_prev = Pokemon::where('number', '=', $pokemon->number)
                ->where('id', '<', $id)
                ->whereNotNull('original')
                ->orderBy('number', 'desc')
                ->orderBy('id', 'desc')
                ->first();
            if (!$pokemon_prev) {
                $pokemon_prev = Pokemon::where('number', '<', $pokemon->number)
                    ->whereNotNull('original')
                    ->orderBy('number', 'desc')
                    ->orderBy('id', 'desc')
                    ->first();
            }
            if ($pokemon_prev) {
                $pokemon_prev = $pokemon_prev->id;
            } else {
                $pokemon_prev = null;
            }
            $pokemon_next = Pokemon::where('number', '=', $pokemon->number)
                ->whereNotNull('original')
                ->where('id', '>', $id)
                ->orderBy('number', 'asc')
                ->orderBy('id', 'asc')
                ->first();
            if (!$pokemon_next) {
                $pokemon_next = Pokemon::where('number', '>', $pokemon->number)
                    ->whereNotNull('original')
                    ->orderBy('number', 'asc')
                    ->orderBy('id', 'asc')
                    ->first();
            }
            if ($pokemon_next) {
                $pokemon_next = $pokemon_next->id;
            } else {
                $pokemon_next = null;
            }

            $statistic = Statistic::where('pokemon_id', $id)->first();

            return view('pokemon.edit-form', compact(['pokemon', 'pokemons', 'types', 'pokemon_type', 'pokemon_prev', 'pokemon_next', 'statistic']));
        } else {
            
            Alert::error('Error', 'No pokemon form found.');
            
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
                'type'   => 'required',
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
                $pokemon->slug = str_slug($request->name);

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

                if ($request->type != NULL) {
                    $pokemon->types()->sync($request->type);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateForm(Request $request, $id)
    {
        $pokemon = Pokemon::find($id);
        if ($pokemon) {
            $data = $request->all();
            $rules = [
                'original_pokemon' => 'required',
                'name'   => 'required|unique:pokemons,name,'.$id,
                'avatar' => 'image|mimes:jpeg,jpg,png',
                'type'   => 'required',
            ];
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
           
            DB::beginTransaction();
            try {
                $avatar = Image::find($pokemon->avatar);
                $slug = str_slug($request->name);
                $original_pokemon = Pokemon::find($request->original_pokemon);
                $pokemon->number = $original_pokemon->number;
                $pokemon->name = $request->name;
                $pokemon->slug = $slug;
                $pokemon->original = $request->original_pokemon;

                if ($request->hasFile('avatar')) {
                    if ($avatar) {
                        $extension = $request->avatar->extension();
                        $avatar->url = $request->avatar->storeAs('public/images/pokemon', $slug.'.'.$extension);
                    } else {
                        $avatar = new Image();
                        $extension = $request->avatar->extension();
                        $avatar->url = $request->avatar->storeAs('public/images/pokemon', $slug.'.'.$extension);
                        $avatar->table = 'pokemons';
                        $avatar->meta = 'avatar';
                    }
    
                    $avatar->save();
                    $pokemon->avatar = $avatar->id;
                }

                if ($request->type != NULL) {
                    $pokemon->types()->sync($request->type);
                }
                
                $pokemon->pokemon()->associate($original_pokemon);

                $pokemon->save();
                if ($request->hasFile('avatar')) {
                    $avatar->value = $pokemon->id;
                    $avatar->save();
                }
                
                DB::commit();
                
                Alert::success('Success', 'You have successfully updated the pokemon form.');
                
                return redirect()->back();
                
            } catch (Exception $e) {
                DB::rollback();
                Alert::error('Error', 'Updated pokemon form failed, please try again.');
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatistic(Request $request, $id)
    {
        $pokemon = Pokemon::find($id);
        if ($pokemon) {
            $data = $request->all();
            $rules = [
                'hp' => 'required|integer',
                'attack' => 'required|integer',
                'defense' => 'required|integer',
                'sp_attack' => 'required|integer',
                'sp_defense' => 'required|integer',
                'speed' => 'required|integer',
            ];
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
           
            DB::beginTransaction();
            try {
                $statistic = Statistic::where('pokemon_id', $id)->first();
                if ($statistic) {
                    $statistic->hp = $request->hp;
                    $statistic->attack = $request->attack;
                    $statistic->defense = $request->defense;
                    $statistic->special_attack = $request->sp_attack;
                    $statistic->special_defense = $request->sp_defense;
                    $statistic->speed = $request->speed;
                } else {
                    $statistic = new Statistic;
                    $statistic->hp = $request->hp;
                    $statistic->attack = $request->attack;
                    $statistic->defense = $request->defense;
                    $statistic->special_attack = $request->sp_attack;
                    $statistic->special_defense = $request->sp_defense;
                    $statistic->speed = $request->speed;
                    $statistic->pokemon()->associate($pokemon);
                }
                
                $statistic->save();
                
                DB::commit();
                
                Alert::success('Success', 'You have successfully updated statistic.');
                
                return redirect()->back();
                
            } catch (Exception $e) {
                DB::rollback();
                Alert::error('Error', 'Updated statistic failed, please try again.');
                return redirect()->back()->withInput();
                
            }
            
        } else {
            
            Alert::error('Error', 'No pokemon found.');
            
            return redirect()->route('pokemons');
            
        }
    }
}
