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
        $('select').each(function () {
            $(this).select2({
                theme: 'bootstrap4',
                placeholder: $(this).attr('placeholder'),
            });
        });
        
    }

    // init
	return {
		init: function() {
			HotKey();
		}
	};

}();