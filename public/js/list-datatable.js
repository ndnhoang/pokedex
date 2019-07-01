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
                {data: 'number', name: 'number'},
                {data: 'pokemon_avatar', name: 'pokemon_avatar', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'pokemon_type', name: 'pokemon_type'},
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
                {data: 'name', name: 'name'},
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
                {data: 'number', name: 'number'},
                {data: 'pokemon_avatar', name: 'pokemon_avatar', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
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
                {data: 'number', name: 'number'},
                {data: 'pokemon_avatar', name: 'pokemon_avatar', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'hp', name: 'hp'},
                {data: 'attack', name: 'attack'},
                {data: 'defense', name: 'defense'},
                {data: 'special_attack', name: 'special_attack'},
                {data: 'special_defense', name: 'special_defense'},
                {data: 'speed', name: 'speed'},
                {data: 'total', name: 'total'},
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
        }
    };
}();