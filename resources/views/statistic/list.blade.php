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
                    List Pokemon Statistics
                    <div class="tools float-right">
                        <form class="form-inline d-inline-flex" action="{{ route('statistic.delete') }}" method="post" id="remove_statistics_form">
                            @csrf
                            <input type="hidden" name="ids" value="">
                            <button class="btn btn-secondary btn-sm" type="submit" id="remove_statistics_btn">Remove</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @include('layouts.messages')
                    <table id="list_statistics" class="table table-striped table-bordered table-hover" url="{{ route('statistics') }}">
                        <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkboxs">
                                        <label class="custom-control-label" for="checkboxs"></label>
                                    </div>
                                </th>
                                <th>No.</th>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>HP</th>
                                <th>Attack</th>
                                <th>Defense</th>
                                <th>Sp. Attack</th>
                                <th>Sp. Defense</th>
                                <th>Speed</th>
                                <th>Total</th>
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
