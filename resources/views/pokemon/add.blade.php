@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form" action="" method="post" id="add_pokemon_form">
                    <div class="card-header">Add Pokemon</div>

                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            You have some form errors. Please check below.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="form-group">
                            <label for="number">Number</label>
                            <input type="text" name="number" required id="number" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" required id="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Avatar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="avatar" id="avatar" required>
                                <label class="custom-file-label" for="avatar">Choose file</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" value="Add" class="btn btn-success">
                        <a href="#" class="btn btn-secondary float-right">Return to list</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
