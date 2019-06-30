<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statistic;
use DataTables;
use DB;
use Alert;
use App\Pokemon;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $statistics = Statistic::with(['pokemon' => function($query) {
                                $query->orderBy('number', 'asc');
                            }])
                            ->get();
            return DataTables::of($statistics)
                ->addColumn('checkbox', function ($statistic) {
                    return '<div class="custom-control custom-checkbox"><input type="checkbox" value="'.$statistic->id.'" id="check-'.$statistic->id.'" class="custom-control-input"><label class="custom-control-label" for="check-'.$statistic->id.'"></label></div>';
                })
                ->addColumn('pokemon_avatar', function ($statistic) {
                    $pokemon = $statistic->pokemon;
                    return '<img src="'.$pokemon->image->getUrl($pokemon->avatar).'" alt="'.$pokemon->name.'" />';
                })
                ->addColumn('pokemon_name', function($statistic) {
                    return '<a href="'.route('pokemon.edit', ['id' => $statistic->pokemon_id]).'#statistic">'.$statistic->pokemon->name.'</a>';
                })
                ->rawColumns(['checkbox', 'pokemon_avatar', 'pokemon_name'])
                ->make(true);
        }
        return view('statistic.list');
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

            Statistic::whereIn('id', $ids)->delete();
            DB::commit();
            
            Alert::success('Success', 'You have successfully deleted the pokemon statistic.');
            
            return redirect()->back();
            
            
        } catch (Exception $e) {
            DB::rollback();
            
            Alert::error('Error', 'Deleted pokemon statistic failed, please try again.');

            return redirect()->back();
            
        }
    }

}
