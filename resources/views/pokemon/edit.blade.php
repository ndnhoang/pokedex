@extends('layouts.app')

@section('content')

    <ul class="nav nav-tabs" id="editTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="information-tab" data-toggle="tab" href="#information" role="tab" aria-controls="information" aria-selected="true">Information</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="statistic-tab" data-toggle="tab" href="#statistic" role="tab" aria-controls="statistic" aria-selected="false">Statistic</a>
        </li>
    </ul>
    <div class="tab-content" id="editTabContent">
        <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
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
                                                @if (old('type') && in_array($type->id, old('type')))
                                                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                                @elseif ($pokemon_type && in_array($type->id, $pokemon_type))
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
        </div>
        <div class="tab-pane fade" id="statistic" role="tabpanel" aria-labelledby="statistic-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form class="form needs-validation custom-form" action="{{ route('statistic.edit', ['id' => $pokemon->id]) }}" method="post" id="statistic_pokemon_form">
                            @csrf
                            <div class="card-header">
                                Statistic Pokemon
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
                                    <label for="hp">HP <span class="text-danger">*</span></label>
                                    <input type="number" name="hp" required id="hp" value="{{ old('hp') ? old('hp') : ($statistic ? $statistic->hp : '') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="attack">Attack <span class="text-danger">*</span></label>
                                    <input type="number" name="attack" required id="attack" value="{{ old('attack') ? old('attack') : ($statistic ? $statistic->attack : '') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="defense">Defense <span class="text-danger">*</span></label>
                                    <input type="number" name="defense" required id="defense" value="{{ old('defense') ? old('defense') : ($statistic ? $statistic->defense : '') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="sp_attack">Special Attack <span class="text-danger">*</span></label>
                                    <input type="number" name="sp_attack" required id="sp_attack" value="{{ old('sp_attack') ? old('sp_attack') : ($statistic ? $statistic->special_attack : '') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="sp_defense">Special Defense <span class="text-danger">*</span></label>
                                    <input type="number" name="sp_defense" required id="sp_defense" value="{{ old('sp_defense') ? old('sp_defense') : ($statistic ? $statistic->special_defense : '') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="speed">Speed <span class="text-danger">*</span></label>
                                    <input type="number" name="speed" required id="speed" value="{{ old('speed') ? old('speed') : ($statistic ? $statistic->speed : '') }}" class="form-control">
                                </div>
                            </div>
        
                            <div class="card-footer">
                                <input type="submit" value="Update" class="btn btn-success">
                                <a href="{{ route('statistics') }}" class="btn btn-secondary float-right">Return to list</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
