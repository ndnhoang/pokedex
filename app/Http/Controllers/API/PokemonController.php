<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pokemon;
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
        return Pokemon::orderBy('number', 'asc')
            ->take($count)
            ->skip($start - 1)
            ->get()
            ->map(function($pokemon) {
                $pokemon->avatar = $pokemon->image->getUrl($pokemon->avatar);
                $pokemon->types = $pokemon->types;
                return $pokemon;
            });
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
