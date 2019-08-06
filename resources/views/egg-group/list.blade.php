@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @include('layouts.messages')
            <div class="card">
                <div class="card-header">
                    List Egg Groups
                    <div class="tools float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('egg_group.add') }}">Add</a>
                        <form class="form-inline d-inline-flex" action="{{ route('egg_group.delete') }}" method="post" id="remove_egg_group_form">
                            @csrf
                            <input type="hidden" name="ids" value="">
                            <button class="btn btn-secondary btn-sm" type="submit" id="remove_egg_group_btn">Remove</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @include('layouts.messages')
                    <table id="list_egg_groups" class="table table-striped table-bordered table-hover" url="{{ route('egg_groups') }}">
                        <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkboxs">
                                        <label class="custom-control-label" for="checkboxs"></label>
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
