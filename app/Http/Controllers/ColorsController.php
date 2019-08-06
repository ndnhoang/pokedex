<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Color;
use DataTables;
use Validator;
use DB;
use Alert;

class ColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $colors = Color::query();
            return DataTables::of($colors)
                ->addColumn('checkbox', function ($record) {
                    return '<div class="custom-control custom-checkbox"><input type="checkbox" value="'.$record->id.'" id="check-'.$record->id.'" class="custom-control-input"><label class="custom-control-label" for="check-'.$record->id.'"></label></div>';
                })
                ->addColumn('name', function ($record) {
                    return '<a href="'.route('color.edit', ['id' => $record->id]).'">'.$record->name.'</a>';
                })
                ->rawColumns(['checkbox', 'name'])
                ->orderColumn('name', 'name $1')
                ->make(true);
        }
        return view('color.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('color.add');
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
            'name'   => 'required|unique:colors',
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {

            $color = new Color();
            $color->name = $request->name;
            $color->save();

            DB::commit();

            Alert::success('Success', 'You have successfully added the color.');

            return redirect()->back();

        } catch (Exception $e) {
            DB::rollback();
            Alert::error('Error', 'Added color failed, please try again.');
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
        $color = Color::find($id);
        if ($color) {
            return view('color.edit', compact(['color']));
        } else {
            Alert::error('Error', 'No color found.');

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
        $color = Color::find($id);
        if ($color) {
            $data = $request->all();
            $rules = [
                'name'   => 'required|unique:colors,name,'.$id,
            ];
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();
            try {

                $color->name = $request->name;
                $color->save();

                DB::commit();

                Alert::success('Success', 'You have successfully updated the color.');

                return redirect()->back();

            } catch (Exception $e) {
                DB::rollback();
                Alert::error('Error', 'Updated color failed, please try again.');
                return redirect()->back()->withInput();

            }
        } else {

            Alert::error('Error', 'No color found.');

            return redirect()->route('colors');

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

            Alert::warning('Warning', 'You have not selected any color.');

            return redirect()->back();

        }
        DB::beginTransaction();
        try {
            $ids = explode(',', $ids);

            Color::whereIn('id', $ids)->delete();
            DB::commit();

            Alert::success('Success', 'You have successfully deleted the color.');

            return redirect()->back();


        } catch (Exception $e) {
            DB::rollback();

            Alert::error('Error', 'Deleted color failed, please try again.');

            return redirect()->back();

        }
    }
}
