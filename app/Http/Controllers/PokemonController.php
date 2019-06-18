<?php

namespace App\Http\Controllers;

use App\Pokemon;
use App\Image;
use Illuminate\Http\Request;
use Validator;
use DB;
use DataTables;
use Storage;

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
                    return '<img src="'.Storage::url($pokemon->image->getUrl($pokemon->avatar)).'" alt="'.$pokemon->name.'" />';
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
                
                $request->session()->flash('success', 'You have successfully added the pokemon.');
                
                return redirect()->back();
                
            } catch (Exception $e) {
                DB::rollback();
                $request->session()->flash('error', 'Added pokemon failed, please try again.');
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
            
            $request->session()->flash('error', 'No pokemon found.');
            
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
                
                $request->session()->flash('success', 'You have successfully updated the pokemon.');
                
                return redirect()->back();
                
            } catch (Exception $e) {
                DB::rollback();
                $request->session()->flash('error', 'Updated pokemon failed, please try again.');
                return redirect()->back()->withInput();
                
            }
            
        } else {
            
            $request->session()->flash('error', 'No pokemon found.');
            
            return redirect()->route('pokemons');
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
