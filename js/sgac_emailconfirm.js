jQuery(document).ready(function() {

	jQuery('#sgac_confirmationemail').click(function(e) {
		var email = jQuery('input#sgac_email').val();
		var interest = jQuery('input:radio[name=sgac_interest]:checked').val();
		var nonce = jQuery('#access_course_interest').data('nonce');

// check for valid email and insert error message if necessary

// check that interest != "" and insert error message if necessary

		var data = {
				action: "sgacemail",
				email: email,
				interest: interest,
				nonce: nonce
		}
		console.log(data);
		// console.log(email);
		// console.log(interest);
		jQuery.ajax({
			url: ajaxsgac_object.ajaxsgac_url, 
			type: "POST",
			data: data,
			// beforeSend: function () {
			// },
			success: function(response, textStatus, jqXHR) {
				jQuery('#email_error').hide();
				jQuery('#interest_error').hide();				

					if (response == 'bad_email') {
						jQuery('#email_error').show();
						return;
					};
					if (response == 'no_interest') {
						jQuery('#interest_error').show();
						return;
					}
					else {
						jQuery('#confirm_modal').appendTo('body').modal({
							backdrop: 'static'
						});
					}
			},
			error: function(jqXHR,textStatus,errorThrown) {
				// console.log(errorThrown);
			}
		});
		e.preventDefault(); //<--- THIS made me waste about 6 hours. Without preventing default, the form submits a GET request and DOES NOT WORK!! Grr
	});
	jQuery('#exit_modal').click(function(e) {
		jQuery('#sgac_email').val('');
		jQuery('input[name=sgac_interest]').removeAttr('checked');
	});
});