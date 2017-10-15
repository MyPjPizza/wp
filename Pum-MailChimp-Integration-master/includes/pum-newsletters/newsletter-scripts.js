var PUMNewsletter;

(function ( $ ) {
	PUMNewsletter = {

		//Function to submit the subscription form
		submit: function( $form ) {
			var data = {
				action: 'pum_sub_form_submit',
				sub_data: $form.serialize()
			};

			$form.find( '.sub_form_button' ).prop( 'disabled', true );
			$form.addClass( 'pum-sub-form-loading' );
			$form.prepend( '<span class="spinner-loader">Loading…</span>' );

			$.ajax({
          url: pum_sub_ajax_object.ajaxurl,
          type: 'POST',
          dataType: 'json',
          data: data
      })
			.done(function( response ) {
				PUMNewsletter.response( $form, response );
			})
			.fail(function( jqXHR, textStatus, errorThrown ) {
				console.log( "Error: type of " + textStatus + " with message of " + errorThrown );
			});
		},

		//Function for displaying success or error message
		response: function( $form, response ) {
			$form.find( '.spinner-loader' ).remove();
			if ( response.result === 'success' ) {
				$( $form ).trigger( 'pumNewsletterSuccess' );
				$form.addClass( 'pum-newsletter-success' );
				$form.empty();
				$form.append( '<p class="pum-newsletter-success-msg">' + response.message + '</p>' );
			} else {
				//Log any api error message
				console.log( response.api_error_message );

				//Trigger main error event, add main error class, and reset form
				$( $form ).trigger( 'pumNewsletterError' );
				$form.addClass('pum-newsletter-error');
				$form.removeClass( 'pum-sub-form-loading' );
				$form.find( '.pum-newsletter-error-msg' ).text( response.message );
				$form.find( '.sub_form_button' ).prop( 'disabled', false );

				//Trigger event and add class for given error_type
				switch ( response.error_type ) {
					case 'already_subscribed':
						$( $form ).trigger( 'pumNewsletterErrorAlreadySubscribed' );
						$form.addClass( 'pum-newsletter-error-already-subscribed' );
						break;
					case 'empty_name_email':
						$( $form ).trigger( 'pumNewsletterErrorEmptyNameEmail' );
						$form.addClass( 'pum-newsletter-error-empty-name-email' );
						break;
					case 'invalid_email':
						$( $form ).trigger( 'pumNewsletterErrorInvalidEmail' );
						$form.addClass( 'pum-newsletter-error-invalid-email' );
						break;
					default:
						$( $form ).trigger( 'pumNewsletterErrorDefault' );
						$form.addClass( 'pum-newsletter-error-default' );
				}
			}
		}

	};

	$( document ).ready(function() {
	//Attaches subscription function to subscribe button
		$( '.sub_form_button' ).on( 'click', function( event ) {
			event.preventDefault();
			PUMNewsletter.submit( $( this ).closest( '.pum_sub_form' ) );
		});
	});

}( jQuery ));
