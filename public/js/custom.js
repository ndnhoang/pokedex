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
    }

    // init
	return {
		init: function() {
			HotKey();
		}
	};

}();