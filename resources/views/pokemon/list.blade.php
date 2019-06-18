@extends('layouts.app')
<?php 
    use App\Image;
?>
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    List Pokemon
                    <div class="tools float-right">
                        <a class="btn btn-primary" href="{{ route('pokemon.add') }}">Add</a>
                        <button class="btn btn-secondary" type="button" id="remove_pokemon_btn">Remove</button>
                    </div>
                </div>
                <div class="card-body">
                    @include('layouts.messages')
                    <table id="list_pokemon" class="table table-striped table-bordered table-hover" url="{{ route('pokemons') }}">
                        <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkboxs">
                                        <label class="custom-control-label" for="checkboxs"</label>
                                    </div>
                                </th>
                                <th>No.</th>
                                <th>Avatar</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
