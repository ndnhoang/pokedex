@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form needs-validation custom-form" action="{{ route('pokemon.edit', ['id' => $pokemon->id]) }}" method="post" id="edit_pokemon_form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        Edit Pokemon
                        <div class="tools float-right">
                        @if ($pokemon_prev)
                            <a class="mr-1 btn-prev" href="{{ route('pokemon.edit', ['id' => $pokemon_prev]) }}"><i class="fas fa-chevron-left"></i></a>
                        @endif
                        @if ($pokemon_next)
                            <a class="ml-1 btn-next" href="{{ route('pokemon.edit', ['id' => $pokemon_next]) }}"><i class="fas fa-chevron-right"></i></a>
                        @endif
                    </div>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible fade d-none">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            You have some form errors. Please check below.  
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-server">
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
                            <input type="text" name="number" required id="number" value="{{ old('number') ? old('number') : $pokemon->number }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" required id="name" value="{{ old('name') ? old('name') : $pokemon->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="type">Type <span class="text-danger">*</span></label>
                            <select id="type" name="type[]" class="custom-select select-multi" multiple placeholder="Select type" required>
                                @if ($types)
                                    @foreach ($types as $type)
                                        @if ($pokemon_type && in_array($type->id, $pokemon_type))
                                            <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                        @else
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="avatar">Avatar <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="avatar" id="avatar">
                                <label class="custom-file-label" for="avatar">Choose file</label>
                            </div>
                            @if ($pokemon->avatar)
                                <img class="preview" src="{{ $pokemon->image->getUrl($pokemon->avatar) }}" alt="{{ $pokemon->name }}" />
                            @else
                                <img class="preview" src="{{ asset('images/no-image.jpg') }}" alt="Avatar" />
                            @endif
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" value="Update" class="btn btn-success">
                        <a href="{{ route('pokemons') }}" class="btn btn-secondary float-right">Return to list</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
