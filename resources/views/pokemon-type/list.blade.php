@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @include('layouts.messages')
            <div class="card">
                <div class="card-header">
                    List Pokemon Type
                    <div class="tools float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('type.add') }}">Add</a>
                        <form class="form-inline d-inline-flex" action="" method="post" id="remove_pokemon_type_form">
                            @csrf
                            <input type="hidden" name="ids" value="">
                            <button class="btn btn-secondary btn-sm" type="submit" id="remove_pokemon_type_btn">Remove</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @include('layouts.messages')
                    <table id="list_pokemon_type" class="table table-striped table-bordered table-hover" url="{{ route('types') }}">
                        <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkboxs">
                                        <label class="custom-control-label" for="checkboxs"</label>
                                    </div>
                                </th>
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