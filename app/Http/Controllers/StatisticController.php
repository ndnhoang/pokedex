<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statistic;
use DataTables;
use DB;
use Alert;
use App\Pokemon;
use Illuminate\Support\Facades\Validator;

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
            $statistics = Statistic::join('pokemons', 'statistics.pokemon_id', '=', 'pokemons.id')
                            ->select('statistics.*', 'number', 'name', 'avatar', DB::raw('SUM(hp + attack + defense + special_attack + special_defense + speed) as total'))
                            ->groupBy('id');

            $datatables = DataTables::of($statistics)
            ->addColumn('checkbox', function ($statistic) {
                return '<div class="custom-control custom-checkbox"><input type="checkbox" value="'.$statistic->id.'" id="check-'.$statistic->id.'" class="custom-control-input"><label class="custom-control-label" for="check-'.$statistic->id.'"></label></div>';
            })
            ->addColumn('number', function($statistic) {
                if ($statistic->pokemon->original == null) {
                    return '<a href="'.route('pokemon.edit', ['id' => $statistic->pokemon_id]).'#statistic">#'.$statistic->pokemon->number.'</a>';
                } else {
                    return '<a href="'.route('pokemon.form.edit', ['id' => $statistic->pokemon_id]).'#statistic">#'.$statistic->pokemon->number.'</a>';
                }
            })
            ->addColumn('pokemon_avatar', function ($statistic) {
                $pokemon = $statistic->pokemon;
                return '<img src="'.$pokemon->image->getUrl($pokemon->avatar).'" alt="'.$pokemon->name.'" />';
            })
            ->addColumn('name', function($statistic) {
                if ($statistic->pokemon->original == null) {
                    return '<a href="'.route('pokemon.edit', ['id' => $statistic->pokemon_id]).'#statistic">'.$statistic->pokemon->name.'</a>';
                } else {
                    return '<a href="'.route('pokemon.form.edit', ['id' => $statistic->pokemon_id]).'#statistic">'.$statistic->pokemon->name.'</a>';
                }
            })
            ->addColumn('total', function($statistic) {
                return '<strong>'.$statistic->total.'</strong>';
            })
            ->rawColumns(['checkbox', 'number', 'pokemon_avatar', 'name', 'total'])
            ->orderColumns(['number', 'name', 'total'], ':column $1');

            $search = $request->search['value'];
            if ($search) {
                $statistics->having('number','like', '%'.$search.'%');
                $statistics->orHaving('name','like', '%'.$search.'%');
                $statistics->orHaving('hp','like', '%'.$search.'%');
                $statistics->orHaving('attack','like', '%'.$search.'%');
                $statistics->orHaving('defense','like', '%'.$search.'%');
                $statistics->orHaving('special_attack','like', '%'.$search.'%');
                $statistics->orHaving('special_defense','like', '%'.$search.'%');
                $statistics->orHaving('speed','like', '%'.$search.'%');
                $statistics->orHaving('total','like', '%'.$search.'%');
            }

            return $datatables->make(true);
        }
        return view('statistic.list');
    }

    public function update(Request $request, $id)
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
