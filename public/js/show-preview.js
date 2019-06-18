var ShowPreview = function() {
    // show avatar add pokemon
    var AddPokemonPreview = function() {
        var form = $('#add_pokemon_form');
        var input = $('.custom-file-input', form);
        var label = $('.custom-file-label', form);
        var preview = $('.preview', form);
        var preview_source = preview.attr('src');
        var label_text = label.text();

        $('#add_pokemon_form').on('change', input, function() {
            var filename = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [filename]);
        });
    
        $(document).on('fileselect', input, function(event, filename) {
            if( label.length ) {
                if (input.val()) {
                    label.text(filename);
                } else {
                    label.text(label_text);
                }
            }
        });
    
        function readURL(file_input) {
            if (file_input.files && file_input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    var result = e.target.result;
                    if (result.indexOf('data:image/jpeg') > -1 || result.indexOf('data:image/png') > -1) {
                        preview.attr('src', result);
                    } else {
                        preview.attr('src', preview_source);
                    }
                }
                
                reader.readAsDataURL(file_input.files[0]);
            } else {
                preview.attr('src', preview_source);
            }
        }
    
        input.change(function(){
            readURL(this);
        });
    }

    // show avatar edit pokemon
    var EditPokemonPreview = function() {
        var form = $('#edit_pokemon_form');
        var input = $('.custom-file-input', form);
        var label = $('.custom-file-label', form);
        var preview = $('.preview', form);
        var preview_source = preview.attr('src');
        var label_text = label.text();

        $('#edit_pokemon_form').on('change', input, function() {
            var filename = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [filename]);
        });
    
        $(document).on('fileselect', input, function(event, filename) {
            if( label.length ) {
                if (input.val()) {
                    label.text(filename);
                } else {
                    label.text(label_text);
                }
            }
        });
    
        function readURL(file_input) {
            if (file_input.files && file_input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    var result = e.target.result;
                    if (result.indexOf('data:image/jpeg') > -1 || result.indexOf('data:image/png') > -1) {
                        preview.attr('src', result);
                    } else {
                        preview.attr('src', preview_source);
                    }
                }
                
                reader.readAsDataURL(file_input.files[0]);
            } else {
                preview.attr('src', preview_source);
            }
        }
    
        input.change(function(){
            readURL(this);
        });
    }

    return {
        init: function() {
            AddPokemonPreview();
            EditPokemonPreview();
        }
    };
}();
