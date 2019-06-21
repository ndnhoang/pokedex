@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form needs-validation custom-form" action="{{ route('pokemon.add') }}" method="post" id="add_pokemon_form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">Add Pokemon</div>

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
                            <label for="number">Number <span class="text-danger">*</span></label>
                            <input type="text" name="number" required id="number" value="{{ old('number') }}" class="form-control" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" required id="name" value="{{ old('name') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="type">Type <span class="text-danger">*</span></label>
                            <select id="type" name="type" class="custom-select" multiple placeholder="Select type">
                                @if ($types)
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="avatar">Avatar <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="avatar" id="avatar" required>
                                <label class="custom-file-label" for="avatar">Choose file</label>
                            </div>
                            <img class="preview" src="{{ asset('images/no-image.jpg') }}" alt="Avatar" />
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" value="Add" class="btn btn-success">
                        <a href="{{ route('pokemons') }}" class="btn btn-secondary float-right">Return to list</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
