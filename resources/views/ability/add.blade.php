@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form needs-validation custom-form" action="{{ route('ability.add') }}" method="post" id="add_ability_form">
                    @csrf
                    <div class="card-header">Add Ability</div>

                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible fade d-none">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            You have some form errors. Please check below.
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @include('layouts.messages')

                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" required id="name" value="{{ old('name') }}" class="form-control" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="effect">Effect <span class="text-danger">*</span></label>
                            <textarea name="effect" id="effect" class="form-control" rows="5">{{ old('effect') }}</textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" value="Add" class="btn btn-success">
                        <a href="{{ route('colors') }}" class="btn btn-secondary float-right">Return to list</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
