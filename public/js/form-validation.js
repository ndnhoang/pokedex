var FormValidation = function() {
	// add pokemon
	var FormAddPokemon = function() {
		var form = $('#add_pokemon_form');
		var error = $('.alert-danger', form);
		var error_text = error.text();

		$('#add_pokemon_form').validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "", // validate all fields including form hidden input
			
			errorPlacement: function(error, element) { // render error placement for each input type
			    if (element.parent(".input-group").size() > 0) {
			        error.insertAfter(element.parent(".input-group"));
			    } else if (element.attr("data-error-container")) {
			        error.appendTo(element.attr("data-error-container"));
			    } else if (element.parents('.radio-list').size() > 0) {
			        error.appendTo(element.parents('.radio-list').attr("data-error-container"));
			    } else if (element.parents('.radio-inline').size() > 0) {
			        error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
			    } else if (element.parents('.checkbox-list').size() > 0) {
			        error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
			    } else if (element.parents('.checkbox-inline').size() > 0) {
			        error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
			    } else {
			        error.insertAfter(element); // for other inputs, just perform default behavior
			    }
			},

			invalidHandler: function(event, validator) { //display error alert on form submit   
			    error.show();
			    error.text(error_text);
			    Metronic.scrollTo(error, -200);
			},

			highlight: function(element) { // hightlight error inputs
			    $(element)
			        .closest('.form-group').addClass('has-error'); // set error class to the control group
			},

			unhighlight: function(element) { // revert the change done by hightlight
			    $(element)
			        .closest('.form-group').removeClass('has-error'); // set error class to the control group
			},

			success: function(label) {
			    label
			        .closest('.form-group').removeClass('has-error'); // set success class to the control group
			},

			submitHandler: function(form) {
			    
			},
		});
	};

	// init
	return {
		init: function() {
			FormAddPokemon();
		}
	};
}();