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
            $pokemons = Pokemon::orderBy('number', 'asc')->get();
            return DataTables::of($pokemons)
                ->addColumn('checkbox', function ($pokemon) {
                    return '<div class="custom-control custom-checkbox"><input type="checkbox" value="'.$pokemon->id.'" id="check-'.$pokemon->number.'" class="custom-control-input"><label class="custom-control-label" for="check-'.$pokemon->number.'"></label></div>';
                })
                ->addColumn('pokemon_avatar', function ($pokemon) {
                    return '<img src="'.$pokemon->image->getUrl($pokemon->avatar).'" alt="'.$pokemon->name.'" />';
                })
                ->addColumn('pokemon_name', function ($pokemon) {
                    return '<a href="'.route('pokemon.edit', ['id' => $pokemon->id]).'">'.$pokemon->name.'</a>';
                })
                ->rawColumns(['checkbox', 'pokemon_avatar', 'pokemon_name'])
                ->make(true);
        }
        return view('pokemon.list');
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
            $pokemon_type = [];
            foreach ($pokemon->types as $type) {
                $pokemon_type[] = $type->id;
            }
            $types = PokemonType::all();
            return view('pokemon.edit', compact(['pokemon', 'types', 'pokemon_type']));
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
