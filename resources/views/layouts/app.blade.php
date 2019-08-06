<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- Bootstrap 4 --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{--  DataTable  --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    {{--  Select2 Bootstrap 4  --}}
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css') }}">

    {{-- Font awesome 5 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container-fluid pt-4">
            <div class="row">
                {{-- Sidebar --}}
                <div class="col-md-2">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('pokemons') }}">Pokemons</a>
                            <ul>
                                <li class="nav-item"><a href="{{ route('pokemon.add') }}">Add Pokemon</a></li>
                                <li class="nav-item"><a href="{{ route('pokemons') }}">List Pokemons</a></li>
                                <li class="nav-item"><a href="{{ route('pokemon.form.add') }}">Add Pokemon Form</a></li>
                                <li class="nav-item"><a href="{{ route('pokemon.forms') }}">List Pokemon Forms</a></li>
                                <li class="nav-item"><a href="{{ route('statistics') }}">List Pokemon Statistics</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('types') }}">Pokemon Type</a>
                            <ul>
                                <li class="nav-item"><a href="{{ route('type.add') }}">Add Pokemon Type</a></li>
                                <li class="nav-item"><a href="{{ route('types') }}">List Pokemon Type</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('species') }}">Species</a>
                            <ul>
                                <li class="nav-item"><a href="{{ route('species.add') }}">Add Species</a></li>
                                <li class="nav-item"><a href="{{ route('species') }}">List Species</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('egg_groups') }}">Egg Group</a>
                            <ul>
                                <li class="nav-item"><a href="{{ route('egg_group.add') }}">Add Egg Group</a></li>
                                <li class="nav-item"><a href="{{ route('egg_groups') }}">List Egg Group</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('colors') }}">Colors</a>
                            <ul>
                                <li class="nav-item"><a href="{{ route('color.add') }}">Add Color</a></li>
                                <li class="nav-item"><a href="{{ route('colors') }}">List Colors</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('colors') }}">Abilities</a>
                            <ul>
                                <li class="nav-item"><a href="{{ route('ability.add') }}">Add Ability</a></li>
                                <li class="nav-item"><a href="{{ route('colors') }}">List Abilities</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                {{-- #Sidebar --}}
                {{-- Content --}}
                <div class="col-md-10">
                    @yield('content')
                </div>
                {{-- #Content --}}
            </div>
        </main>
    </div>
    {{-- Scripts --}}
    {{-- Bootstrap 4  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    {{-- Validation --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>
    {{--  DataTable  --}}
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>

    <script src="{{ asset('js/form-validation.js') }}" defer></script>
    <script src="{{ asset('js/show-preview.js') }}" defer></script>
    <script src="{{ asset('js/list-datatable.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>



    <script type="text/javascript">
        jQuery(document).ready(function() {
            FormValidation.init();
            ShowPreview.init();
            ListDataTable.init();
            Custom.init();
        });
    </script>
</body>
</html>
