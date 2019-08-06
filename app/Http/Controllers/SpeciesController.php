<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Species;
use DataTables;
use Validator;
use DB;
use Alert;

class SpeciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $species = Species::query();
            return DataTables::of($species)
                ->addColumn('checkbox', function ($record) {
                    return '<div class="custom-control custom-checkbox"><input type="checkbox" value="'.$record->id.'" id="check-'.$record->id.'" class="custom-control-input"><label class="custom-control-label" for="check-'.$record->id.'"></label></div>';
                })
                ->addColumn('name', function ($record) {
                    return '<a href="'.route('species.edit', ['id' => $record->id]).'">'.$record->name.'</a>';
                })
                ->rawColumns(['checkbox', 'name'])
                ->orderColumn('name', 'name $1')
                ->make(true);
        }
        return view('species.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('species.add');
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
            'name'   => 'required|unique:species',
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {

            $species = new Species();
            $species->name = $request->name;
            $species->save();

            DB::commit();

            Alert::success('Success', 'You have successfully added the species.');

            return redirect()->back();

        } catch (Exception $e) {
            DB::rollback();
            Alert::error('Error', 'Added species failed, please try again.');
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
        $species = Species::find($id);
        if ($species) {
            return view('species.edit', compact(['species']));
        } else {
            Alert::error('Error', 'No species found.');

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
        $species = Species::find($id);
        if ($species) {
            $data = $request->all();
            $rules = [
                'name'   => 'required|unique:species,name,'.$id,
            ];
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();
            try {

                $species->name = $request->name;
                $species->save();

                DB::commit();

                Alert::success('Success', 'You have successfully updated the species.');

                return redirect()->back();

            } catch (Exception $e) {
                DB::rollback();
                Alert::error('Error', 'Updated species failed, please try again.');
                return redirect()->back()->withInput();

            }
        } else {

            Alert::error('Error', 'No species found.');

            return redirect()->route('species');

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

            Alert::warning('Warning', 'You have not selected any species.');

            return redirect()->back();

        }
        DB::beginTransaction();
        try {
            $ids = explode(',', $ids);

            Species::whereIn('id', $ids)->delete();
            DB::commit();

            Alert::success('Success', 'You have successfully deleted the species.');

            return redirect()->back();


        } catch (Exception $e) {
            DB::rollback();

            Alert::error('Error', 'Deleted species failed, please try again.');

            return redirect()->back();

        }
    }
}
