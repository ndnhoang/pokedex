@extends('layouts.app')
<?php 
    use App\Image;
?>
@section('content')

    <div class="row">
        <div class="col-md-12">
            @include('layouts.messages')
            <div class="card">
                <div class="card-header">
                    List Pokemon
                    <div class="tools float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('pokemon.add') }}">Add</a>
                        <form class="form-inline d-inline-flex" action="{{ route('pokemon.delete') }}" method="post" id="remove_pokemon_form">
                            @csrf
                            <input type="hidden" name="ids" value="">
                            <button class="btn btn-secondary btn-sm" type="submit" id="remove_pokemon_btn">Remove</button>
                        </form>
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
                                <th>Type</th>
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
