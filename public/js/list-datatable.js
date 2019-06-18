var ListDataTable = function() {
    // list pokemon
    var ListPokemon = function() {
        var list = $('#list_pokemon');
        var url = list.attr('url');
        list.DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'number', name: 'number'},
                {data: 'pokemon_avatar', name: 'pokemon_avatar', orderable: false, searchable: false},
                {data: 'pokemon_name', name: 'pokemon_name'},
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
    }

    return {
        init: function() {
            ListPokemon();
        }
    };
}();