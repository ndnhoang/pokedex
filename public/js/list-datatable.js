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
                {data: 'pokemon_number', name: 'pokemon_number'},
                {data: 'pokemon_avatar', name: 'pokemon_avatar', orderable: false, searchable: false},
                {data: 'pokemon_name', name: 'pokemon_name'},
                {data: 'pokemon_type', name: 'pokemon_type'},
            ],
            order: [],
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
                {data: 'type', name: 'type'},
            ],
            order: [],
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
        }
    };
}();