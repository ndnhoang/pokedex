var ListDataTable = function() {
    // list pokemon
    var ListPokemon = function() {
        var list = $('#list_pokemon');
        var url = list.attr('url');
        var remove_form = $('#remove_pokemon_form');
        list.DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'number', name: 'pokemons.number'},
                {data: 'pokemon_avatar', name: 'pokemon_avatar', orderable: false, searchable: false},
                {data: 'name', name: 'pokemons.name'},
                {data: 'pokemon_type', name: 'pokemon_type'},
            ],
            order: [1, 'asc'],
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());

                        column.search(val ? val : '', true, false).draw();
                        console.log(val);
                    });
                });
            }
        });

        var checkboxs = $('#checkboxs');
        checkboxs.on('change', function() {
            var checkbox_parent = this;
            var table = checkboxs.parents('table').first();
            if (table.length) {
                var checkbox_child = table.find('input[type=checkbox]');
                if (checkbox_child.length) {
                    if (checkbox_parent.checked) {
                        checkbox_child.each(function() {
                            $(this).prop('checked', true);
                        });
                    } else {
                        checkbox_child.each(function() {
                            $(this).prop('checked', false);
                        });
                    }
                }
            }
        });
        remove_form.on('submit', function(e) {
            var remove_arr = [];
            var checkboxs_child = $('td input[type=checkbox]', list);
            if (checkboxs_child.length) {
                checkboxs_child.each(function() {
                    if (this.checked) {
                        var id = this.value;
                        remove_arr.push(id);
                    }
                });
            }
            console.log(remove_arr.toString());
            $('input[name=ids]', remove_form).val(remove_arr.toString());
        });
    }

    // list pokemon type
    var ListPokemonType = function() {
        var list = $('#list_pokemon_type');
        var url = list.attr('url');
        var remove_form = $('#remove_pokemon_type_form');
        list.DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'name', name: 'pokemon_types.name'},
            ],
            order: [1, 'asc'],
        });

        var checkboxs = $('#checkboxs');
        checkboxs.on('change', function() {
            var checkbox_parent = this;
            var table = checkboxs.parents('table').first();
            if (table.length) {
                var checkbox_child = table.find('input[type=checkbox]');
                if (checkbox_child.length) {
                    if (checkbox_parent.checked) {
                        checkbox_child.each(function() {
                            $(this).prop('checked', true);
                        });
                    } else {
                        checkbox_child.each(function() {
                            $(this).prop('checked', false);
                        });
                    }
                }
            }
        });
        remove_form.on('submit', function(e) {
            var remove_arr = [];
            var checkboxs_child = $('td input[type=checkbox]', list);
            if (checkboxs_child.length) {
                checkboxs_child.each(function() {
                    if (this.checked) {
                        var id = this.value;
                        remove_arr.push(id);
                    }
                });
            }
            console.log(remove_arr.toString());
            $('input[name=ids]', remove_form).val(remove_arr.toString());
        });
    }

    // list pokemon form
    var ListPokemonForm = function() {
        var list = $('#list_pokemon_form');
        var url = list.attr('url');
        var remove_form = $('#remove_pokemon_form_form');
        list.DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'number', name: 'pokemons.number'},
                {data: 'pokemon_avatar', name: 'pokemon_avatar', orderable: false, searchable: false},
                {data: 'name', name: 'pokemons.name'},
                {data: 'pokemon_type', name: 'pokemon_type'},
                {data: 'pokemon_original', name: 'pokemon_original'},
            ],
            order: [1, 'asc'],
        });

        var checkboxs = $('#checkboxs');
        checkboxs.on('change', function() {
            var checkbox_parent = this;
            var table = checkboxs.parents('table').first();
            if (table.length) {
                var checkbox_child = table.find('input[type=checkbox]');
                if (checkbox_child.length) {
                    if (checkbox_parent.checked) {
                        checkbox_child.each(function() {
                            $(this).prop('checked', true);
                        });
                    } else {
                        checkbox_child.each(function() {
                            $(this).prop('checked', false);
                        });
                    }
                }
            }
        });
        remove_form.on('submit', function(e) {
            var remove_arr = [];
            var checkboxs_child = $('td input[type=checkbox]', list);
            if (checkboxs_child.length) {
                checkboxs_child.each(function() {
                    if (this.checked) {
                        var id = this.value;
                        remove_arr.push(id);
                    }
                });
            }
            console.log(remove_arr.toString());
            $('input[name=ids]', remove_form).val(remove_arr.toString());
        });
    }

    // list pokemon statistics
    var ListStatistics = function() {
        var list = $('#list_statistics');
        var url = list.attr('url');
        var remove_form = $('#remove_statistics_form');
        list.DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'number', name: 'pokemons.number', searchable: false},
                {data: 'pokemon_avatar', name: 'pokemon_avatar', orderable: false, searchable: false},
                {data: 'name', name: 'pokemons.name', searchable: false},
                {data: 'hp', name: 'statistics.hp', searchable: false},
                {data: 'attack', name: 'statistics.attack', searchable: false},
                {data: 'defense', name: 'statistics.defense', searchable: false},
                {data: 'special_attack', name: 'statistics.special_attack', searchable: false},
                {data: 'special_defense', name: 'statistics.special_defense', searchable: false},
                {data: 'speed', name: 'statistics.speed', searchable: false},
                {data: 'total', name: 'total', searchable: false},
            ],
            order: [1, 'asc'],
        });

        var checkboxs = $('#checkboxs');
        checkboxs.on('change', function() {
            var checkbox_parent = this;
            var table = checkboxs.parents('table').first();
            if (table.length) {
                var checkbox_child = table.find('input[type=checkbox]');
                if (checkbox_child.length) {
                    if (checkbox_parent.checked) {
                        checkbox_child.each(function() {
                            $(this).prop('checked', true);
                        });
                    } else {
                        checkbox_child.each(function() {
                            $(this).prop('checked', false);
                        });
                    }
                }
            }
        });
        remove_form.on('submit', function(e) {
            var remove_arr = [];
            var checkboxs_child = $('td input[type=checkbox]', list);
            if (checkboxs_child.length) {
                checkboxs_child.each(function() {
                    if (this.checked) {
                        var id = this.value;
                        remove_arr.push(id);
                    }
                });
            }
            console.log(remove_arr.toString());
            $('input[name=ids]', remove_form).val(remove_arr.toString());
        });
    }

    // list species
    var ListSpecies = function() {
        var list = $('#list_species');
        var url = list.attr('url');
        var remove_form = $('#remove_species_form');
        list.DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'name', name: 'species.name'},
            ],
            order: [1, 'asc'],
        });

        var checkboxs = $('#checkboxs');
        checkboxs.on('change', function() {
            var checkbox_parent = this;
            var table = checkboxs.parents('table').first();
            if (table.length) {
                var checkbox_child = table.find('input[type=checkbox]');
                if (checkbox_child.length) {
                    if (checkbox_parent.checked) {
                        checkbox_child.each(function() {
                            $(this).prop('checked', true);
                        });
                    } else {
                        checkbox_child.each(function() {
                            $(this).prop('checked', false);
                        });
                    }
                }
            }
        });
        remove_form.on('submit', function(e) {
            var remove_arr = [];
            var checkboxs_child = $('td input[type=checkbox]', list);
            if (checkboxs_child.length) {
                checkboxs_child.each(function() {
                    if (this.checked) {
                        var id = this.value;
                        remove_arr.push(id);
                    }
                });
            }
            console.log(remove_arr.toString());
            $('input[name=ids]', remove_form).val(remove_arr.toString());
        });
    }

    // list egg groups
    var ListEggGroups = function() {
        var list = $('#list_egg_groups');
        var url = list.attr('url');
        var remove_form = $('#remove_egg_group_form');
        list.DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'name', name: 'egg_groups.name'},
            ],
            order: [1, 'asc'],
        });

        var checkboxs = $('#checkboxs');
        checkboxs.on('change', function() {
            var checkbox_parent = this;
            var table = checkboxs.parents('table').first();
            if (table.length) {
                var checkbox_child = table.find('input[type=checkbox]');
                if (checkbox_child.length) {
                    if (checkbox_parent.checked) {
                        checkbox_child.each(function() {
                            $(this).prop('checked', true);
                        });
                    } else {
                        checkbox_child.each(function() {
                            $(this).prop('checked', false);
                        });
                    }
                }
            }
        });
        remove_form.on('submit', function(e) {
            var remove_arr = [];
            var checkboxs_child = $('td input[type=checkbox]', list);
            if (checkboxs_child.length) {
                checkboxs_child.each(function() {
                    if (this.checked) {
                        var id = this.value;
                        remove_arr.push(id);
                    }
                });
            }
            console.log(remove_arr.toString());
            $('input[name=ids]', remove_form).val(remove_arr.toString());
        });
    }

    // list colors
    var ListColors = function() {
        var list = $('#list_colors');
        var url = list.attr('url');
        var remove_form = $('#remove_color_form');
        list.DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'name', name: 'colors.name'},
            ],
            order: [1, 'asc'],
        });

        var checkboxs = $('#checkboxs');
        checkboxs.on('change', function() {
            var checkbox_parent = this;
            var table = checkboxs.parents('table').first();
            if (table.length) {
                var checkbox_child = table.find('input[type=checkbox]');
                if (checkbox_child.length) {
                    if (checkbox_parent.checked) {
                        checkbox_child.each(function() {
                            $(this).prop('checked', true);
                        });
                    } else {
                        checkbox_child.each(function() {
                            $(this).prop('checked', false);
                        });
                    }
                }
            }
        });
        remove_form.on('submit', function(e) {
            var remove_arr = [];
            var checkboxs_child = $('td input[type=checkbox]', list);
            if (checkboxs_child.length) {
                checkboxs_child.each(function() {
                    if (this.checked) {
                        var id = this.value;
                        remove_arr.push(id);
                    }
                });
            }
            console.log(remove_arr.toString());
            $('input[name=ids]', remove_form).val(remove_arr.toString());
        });
    }

    return {
        init: function() {
            ListPokemon();
            ListPokemonType();
            ListPokemonForm();
            ListStatistics();
            ListSpecies();
            ListEggGroups();
            ListColors();
        }
    };
}();
