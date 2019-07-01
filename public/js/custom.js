var Custom = function() {
    var HotKey = function() {
        $(window).keydown(function(event) {
            if ((event.which == 83 && event.ctrlKey)) {
                event.preventDefault();
                var editTab = $('#editTab');
                if (editTab.length > 0) {
                    $('.nav-link', editTab).each(function() {
                        if ($(this).hasClass('active')) {
                            var currentForm = $(this).attr('aria-controls');
                            $('#' + currentForm + ' form.custom-form').submit();
                        }
                    });
                } else {
                    $('form.custom-form').submit();
                }
                return false;
            } 
            return true;
        });
        $('select.select-multi').each(function () {
            $(this).select2({
                theme: 'bootstrap4',
                placeholder: $(this).attr('placeholder'),
            });
        });

        $(window).keyup(function(e) {
            if (e.keyCode == 37 &&  !$(':focus').is('input, select')) {
                if ($(".tools .btn-prev").length > 0) {
                    var url = $(".tools .btn-prev").attr('href');
                    window.location.href = url;
                }
            }
            if (e.keyCode == 39 &&  !$(':focus').is('input, select')) {
                if ($(".tools .btn-next").length > 0) {
                    var url = $(".tools .btn-next").attr('href');
                    window.location.href = url;
                }
            }
        });
        var type_weakness = [];

        $('#edit_pokemon_type_form select.select-multi').each(function() {
            $('option', this).each(function() {
                if (this.selected && !type_weakness.includes(this.text)) {
                    type_weakness.push(this.text);
                }
            });
        });

        $('#add_pokemon_type_form select.select-multi, #edit_pokemon_type_form select.select-multi').on('select2:select', function(e) {
            var value = e.params.data.text;
            if (!type_weakness.includes(value)) {
                type_weakness.push(value);
            }
        });

        $('#add_pokemon_type_form select.select-multi, #edit_pokemon_type_form select.select-multi').on('select2:unselect', function(e) {
            var value = e.params.data.text;
            var index = type_weakness.indexOf(value);
            if (index > -1) {
                type_weakness.splice(index, 1);
            }
        });
        
        $('#add_pokemon_type_form select.select-multi, #edit_pokemon_type_form select.select-multi').on('select2:open', function(e) {   
            setTimeout(function() {
                $('.select2-results ul li').each(function(e) {
                    var value = $(this).text();
                    if (type_weakness.includes(value)) {
                        $(this).hide();
                    }
                });
            }, 10);
        });
        
    }

    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');

    // init
	return {
		init: function() {
			HotKey();
		}
	};

}();