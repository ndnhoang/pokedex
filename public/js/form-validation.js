var FormValidation = function() {
	// add pokemon
	var FormAddPokemon = function() {
		var form = $('#add_pokemon_form');
		var error = $('.alert-danger', form);
		var error_text = error.html();

		$('#add_pokemon_form').validate({
			errorElement: 'div', //default input error message container
			errorClass: 'invalid-feedback', // default input error message class
			focusInvalid: true, // do not focus the last invalid input
			ignore: "", // validate all fields including form hidden input
			rules: {
				number: "required",
				name: "required",
				avatar: {
					required: true,
					accept: 'image/*',
				},
			},
			errorPlacement: function(error, element) { // render error placement for each input type
			    if (element.parent(".input-group").length > 0) {
			        error.insertAfter(element.parent(".input-group"));
			    } else if (element.attr("data-error-container")) {
			        error.appendTo(element.attr("data-error-container"));
			    } else if (element.parents('.radio-list').length > 0) {
			        error.appendTo(element.parents('.radio-list').attr("data-error-container"));
			    } else if (element.parents('.radio-inline').length > 0) {
			        error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
			    } else if (element.parents('.checkbox-list').length > 0) {
			        error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
			    } else if (element.parents('.checkbox-inline').length > 0) {
			        error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
			    } else {
			        error.insertAfter(element); // for other inputs, just perform default behavior
			    }
			},

			invalidHandler: function(event, validator) { //display error alert on form submit  
				error.html(error_text);
				error.addClass('show').removeClass('d-none');
				form.addClass('was-validated');
			    // Metronic.scrollTo(error, -200);
			},

			highlight: function(element) { // hightlight error inputs
			    $(element)
			        .closest('.form-group').addClass('is-invalid').removeClass('is-valid'); // set error class to the control group
			},

			unhighlight: function(element) { // revert the change done by hightlight
			    $(element)
			        .closest('.form-group').removeClass('is-invalid is-valid'); // set error class to the control group
			},

			success: function(label) {
			    label
			        .closest('.form-group').removeClass('is-invalid').addClass('is-valid'); // set success class to the control group
			},

			submitHandler: function(form) {
				error.addClass('d-none').remove('show');
				form.submit();
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