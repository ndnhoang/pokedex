<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PokemonType;
use DataTables;
use Validator;
use DB;
use Alert;

class PokemonTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $types = PokemonType::orderBy('id', 'asc')->get();
            return DataTables::of($types)
                ->addColumn('checkbox', function ($type) {
                    return '<div class="custom-control custom-checkbox"><input type="checkbox" value="'.$type->id.'" id="check-'.$type->name.'" class="custom-control-input"><label class="custom-control-label" for="check-'.$type->name.'"></label></div>';
                })
                ->addColumn('type', function ($type) {
                    return '<a href="'.route('type.edit', ['id' => $type->id]).'">'.$type->name.'</a>';
                })
                ->rawColumns(['checkbox', 'type'])
                ->make(true);
        }
        return view('pokemon-type.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pokemon-type.add');
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
            'name'   => 'required|unique:pokemon_types',
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();
        try {
            $type = new PokemonType();
            $type->name = $request->name;
            $type->save();

            DB::commit();
            
            Alert::success('Success', 'You have successfully added the pokemon type.');
            
            return redirect()->back();
            
        } catch (Exception $e) {
            DB::rollback();
            Alert::error('Error', 'Added pokemon type failed, please try again.');
            return redirect()->back()->withInput();
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = PokemonType::find($id);
        if ($type) {
            return view('pokemon-type.edit', compact(['type']));
        } else {
            
            Alert::error('Error', 'No pokemon type found.');
            
            return redirect()->back();
            
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $type = PokemonType::find($id);
        if ($type) {
            $data = $request->all();
            $rules = [
                'name'   => 'required|unique:pokemon_types,name,'.$id,
            ];
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
           
            DB::beginTransaction();
            try {

                $type->name = $request->name;
                
                $type->save();
                
                DB::commit();
                
                Alert::success('Success', 'You have successfully updated the pokemon type.');
                
                return redirect()->back();
                
            } catch (Exception $e) {
                DB::rollback();
                Alert::error('Error', 'Updated pokemon type failed, please try again.');
                return redirect()->back()->withInput();
                
            }
            
        } else {
            
            Alert::error('Error', 'No pokemon type found.');
            
            return redirect()->route('types');
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
