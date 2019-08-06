<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EggGroup;
use DataTables;
use Validator;
use DB;
use Alert;

class EggGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $egg_group = EggGroup::query();
            return DataTables::of($egg_group)
                ->addColumn('checkbox', function ($record) {
                    return '<div class="custom-control custom-checkbox"><input type="checkbox" value="'.$record->id.'" id="check-'.$record->id.'" class="custom-control-input"><label class="custom-control-label" for="check-'.$record->id.'"></label></div>';
                })
                ->addColumn('name', function ($record) {
                    return '<a href="'.route('egg_group.edit', ['id' => $record->id]).'">'.$record->name.'</a>';
                })
                ->rawColumns(['checkbox', 'name'])
                ->orderColumn('name', 'name $1')
                ->make(true);
        }
        return view('egg-group.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('egg-group.add');
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
            'name'   => 'required|unique:egg_groups',
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {

            $egg_group = new EggGroup();
            $egg_group->name = $request->name;
            $egg_group->save();

            DB::commit();

            Alert::success('Success', 'You have successfully added the egg group.');

            return redirect()->back();

        } catch (Exception $e) {
            DB::rollback();
            Alert::error('Error', 'Added egg group failed, please try again.');
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
        $egg_group = EggGroup::find($id);
        if ($egg_group) {
            return view('egg-group.edit', compact(['egg_group']));
        } else {
            Alert::error('Error', 'No egg group found.');

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
        $egg_group = EggGroup::find($id);
        if ($egg_group) {
            $data = $request->all();
            $rules = [
                'name'   => 'required|unique:egg_groups,name,'.$id,
            ];
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();
            try {

                $egg_group->name = $request->name;
                $egg_group->save();

                DB::commit();

                Alert::success('Success', 'You have successfully updated the egg group.');

                return redirect()->back();

            } catch (Exception $e) {
                DB::rollback();
                Alert::error('Error', 'Updated egg group failed, please try again.');
                return redirect()->back()->withInput();

            }
        } else {

            Alert::error('Error', 'No egg group found.');

            return redirect()->route('egg_groups');

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

            Alert::warning('Warning', 'You have not selected any egg group.');

            return redirect()->back();

        }
        DB::beginTransaction();
        try {
            $ids = explode(',', $ids);

            EggGroup::whereIn('id', $ids)->delete();
            DB::commit();

            Alert::success('Success', 'You have successfully deleted the egg group.');

            return redirect()->back();


        } catch (Exception $e) {
            DB::rollback();

            Alert::error('Error', 'Deleted egg group failed, please try again.');

            return redirect()->back();

        }
    }
}
