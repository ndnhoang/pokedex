var Custom = function() {
    var HotKey = function() {
        $(window).keydown(function(event) {
            if ((event.which == 83 && event.ctrlKey)) {
                event.preventDefault();
                $('form.custom-form').submit();
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

        $(document).keyup(function(e) {
            if (e.keyCode == 37) {
                if ($(".tools .btn-prev").length > 0) {
                    var url = $(".tools .btn-prev").attr('href');
                    window.location.href = url;
                }
            }
            if (e.keyCode == 39) {
                if ($(".tools .btn-next").length > 0) {
                    var url = $(".tools .btn-next").attr('href');
                    window.location.href = url;
                }
            }
        });
        var type_weakness = [];

        
    }

    // init
	return {
		init: function() {
			HotKey();
		}
	};

}();