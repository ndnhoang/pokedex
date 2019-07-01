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
            $types = PokemonType::query();
            return DataTables::of($types)
                ->addColumn('checkbox', function ($type) {
                    return '<div class="custom-control custom-checkbox"><input type="checkbox" value="'.$type->id.'" id="check-'.$type->name.'" class="custom-control-input"><label class="custom-control-label" for="check-'.$type->name.'"></label></div>';
                })
                ->addColumn('name', function ($type) {
                    return '<a href="'.route('type.edit', ['id' => $type->id]).'">'.$type->name.'</a>';
                })
                ->rawColumns(['checkbox', 'name'])
                ->orderColumn('name', 'name $1')
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
        $types = PokemonType::all();
        return view('pokemon-type.add', compact(['types']));
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
            $weakness = [];
            $weakness['type_0'] = $request->type_0;
            $weakness['type_50'] = $request->type_50;
            $weakness['type_200'] = $request->type_200;
            if ($weakness['type_0'] == null) $weakness['type_0']= array();
            if ($weakness['type_50'] == null) $weakness['type_50']= array();
            if ($weakness['type_200'] == null) $weakness['type_200']= array();
            
            $check_same_type_1 = $check_same_type_2 = $check_same_type_3 = null;

            if ($weakness['type_0'] || $weakness['type_50']) {
                if (count($weakness['type_0']) >= count($weakness['type_50'])) {
                    $check_same_type_1 = array_diff($weakness['type_0'], $weakness['type_50']);
                    if (count($check_same_type_1) > 0 && (count($check_same_type_1) < count($weakness['type_0']))) {
                        $check_same_type_1 = null;
                    }
                } else {
                    $check_same_type_1 = array_diff($weakness['type_50'], $weakness['type_0']);
                    if (count($check_same_type_1) > 0 && (count($check_same_type_1) < count($weakness['type_50']))) {
                        $check_same_type_1 = null;
                    }
                }
                
            } else {
                $check_same_type_1 = 1;
            }

            if ($weakness['type_0'] || $weakness['type_200']) {
                if (count($weakness['type_0']) >= count($weakness['type_200'])) {
                    $check_same_type_2 = array_diff($weakness['type_0'], $weakness['type_200']);
                    if (count($check_same_type_2) > 0 && (count($check_same_type_2) < count($weakness['type_0']))) {
                        $check_same_type_2 = null;
                    }
                } else {
                    $check_same_type_2 = array_diff($weakness['type_200'], $weakness['type_0']);
                    if (count($check_same_type_2) > 0 && (count($check_same_type_2) < count($weakness['type_200']))) {
                        $check_same_type_2 = null;
                    }
                }
            } else {
                $check_same_type_2 = 1;
            }

            if ($weakness['type_50'] || $weakness['type_200']) {
                if (count($weakness['type_50']) >= count($weakness['type_200'])) {
                    $check_same_type_3 = array_diff($weakness['type_50'], $weakness['type_200']);
                    if (count($check_same_type_3) > 0 && (count($check_same_type_3) < count($weakness['type_50']))) {
                        $check_same_type_3 = null;
                    }
                } else {
                    $check_same_type_3 = array_diff($weakness['type_200'], $weakness['type_50']);
                    if (count($check_same_type_3) > 0 && (count($check_same_type_3) < count($weakness['type_200']))) {
                        $check_same_type_3 = null;
                    }
                }
            } else {
                $check_same_type_3 = 1;
            }

            if (!$check_same_type_1 || !$check_same_type_2 || !$check_same_type_3) {
                DB::rollback();
                Alert::error('Error', 'Added pokemon type failed, please try again.');
                return redirect()->back()->withInput();
            }
            $weakness = json_encode($weakness);
            $type = new PokemonType();
            $type->name = $request->name;
            $type->weakness = $weakness;
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
            $types = PokemonType::all();
            $weakness = $type->weakness;
            $weakness = json_decode($weakness);
            $type_0 = $type_50 = $type_200 = null;
            if ($weakness) {
                $type_0 = $weakness->type_0;
                $type_50 = $weakness->type_50;
                $type_200 = $weakness->type_200;
            }
            
            return view('pokemon-type.edit', compact(['type', 'types', 'type_0', 'type_50', 'type_200']));
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
                $weakness = [];
                $weakness['type_0'] = $request->type_0;
                $weakness['type_50'] = $request->type_50;
                $weakness['type_200'] = $request->type_200;
                if ($weakness['type_0'] == null) $weakness['type_0']= array();
                if ($weakness['type_50'] == null) $weakness['type_50']= array();
                if ($weakness['type_200'] == null) $weakness['type_200']= array();
                
                $check_same_type_1 = $check_same_type_2 = $check_same_type_3 = null;

                if ($weakness['type_0'] || $weakness['type_50']) {
                    if (count($weakness['type_0']) >= count($weakness['type_50'])) {
                        $check_same_type_1 = array_diff($weakness['type_0'], $weakness['type_50']);
                        if (count($check_same_type_1) > 0 && (count($check_same_type_1) < count($weakness['type_0']))) {
                            $check_same_type_1 = null;
                        }
                    } else {
                        $check_same_type_1 = array_diff($weakness['type_50'], $weakness['type_0']);
                        if (count($check_same_type_1) > 0 && (count($check_same_type_1) < count($weakness['type_50']))) {
                            $check_same_type_1 = null;
                        }
                    }
                    
                } else {
                    $check_same_type_1 = 1;
                }

                if ($weakness['type_0'] || $weakness['type_200']) {
                    if (count($weakness['type_0']) >= count($weakness['type_200'])) {
                        $check_same_type_2 = array_diff($weakness['type_0'], $weakness['type_200']);
                        if (count($check_same_type_2) > 0 && (count($check_same_type_2) < count($weakness['type_0']))) {
                            $check_same_type_2 = null;
                        }
                    } else {
                        $check_same_type_2 = array_diff($weakness['type_200'], $weakness['type_0']);
                        if (count($check_same_type_2) > 0 && (count($check_same_type_2) < count($weakness['type_200']))) {
                            $check_same_type_2 = null;
                        }
                    }
                } else {
                    $check_same_type_2 = 1;
                }

                if ($weakness['type_50'] || $weakness['type_200']) {
                    if (count($weakness['type_50']) >= count($weakness['type_200'])) {
                        $check_same_type_3 = array_diff($weakness['type_50'], $weakness['type_200']);
                        if (count($check_same_type_3) > 0 && (count($check_same_type_3) < count($weakness['type_50']))) {
                            $check_same_type_3 = null;
                        }
                    } else {
                        $check_same_type_3 = array_diff($weakness['type_200'], $weakness['type_50']);
                        if (count($check_same_type_3) > 0 && (count($check_same_type_3) < count($weakness['type_200']))) {
                            $check_same_type_3 = null;
                        }
                    }
                } else {
                    $check_same_type_3 = 1;
                }

                if (!$check_same_type_1 || !$check_same_type_2 || !$check_same_type_3) {
                    DB::rollback();
                    Alert::error('Error', 'Added pokemon type failed, please try again.');
                    return redirect()->back()->withInput();
                }
                $weakness = json_encode($weakness);
                $type->name = $request->name;
                $type->weakness = $weakness;
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
    public function destroy(Request $request)
    {
        $ids = $request->ids;
        if ($ids == '') {
            
            Alert::warning('Warning', 'You have not selected any pokemon type.');
            
            return redirect()->back();
            
        }
        DB::beginTransaction();
        try {
            $ids = explode(',', $ids);

            PokemonType::whereIn('id', $ids)->delete();
            DB::commit();
            
            Alert::success('Success', 'You have successfully deleted the pokemon type.');
            
            return redirect()->back();
            
            
        } catch (Exception $e) {
            DB::rollback();
            
            Alert::error('Error', 'Deleted pokemon type failed, please try again.');

            return redirect()->back();
            
        }
    }
}
