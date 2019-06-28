@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form needs-validation custom-form" action="{{ route('type.add') }}" method="post" id="add_pokemon_type_form">
                    @csrf
                    <div class="card-header">Add Pokemon Type</div>

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
                            <label for="">Weakness <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="type_0">No effect</label>
                                    <select id="type_0" name="type_0[]" class="custom-select select-multi" multiple placeholder="Select type">
                                        @if ($types)
                                            @foreach ($types as $type)
                                                @if (old('type_0') && in_array($type->id, old('type_0')))
                                                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                                @else
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="type_50">Not very effective</label>
                                    <select id="type_50" name="type_50[]" class="custom-select select-multi" multiple placeholder="Select type">
                                        @if ($types)
                                            @foreach ($types as $type)
                                                @if (old('type_50') && in_array($type->id, old('type_50')))
                                                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                                @else
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="type_200">Super effective</label>
                                    <select id="type_200" name="type_200[]" class="custom-select select-multi" multiple placeholder="Select type">
                                        @if ($types)
                                            @foreach ($types as $type)
                                                @if (old('type_200') && in_array($type->id, old('type_200')))
                                                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                                @else
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" value="Add" class="btn btn-success">
                        <a href="{{ route('types') }}" class="btn btn-secondary float-right">Return to list</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
