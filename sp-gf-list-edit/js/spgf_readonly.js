	
	jQuery(document).ready(function($) {
	
		$(".gform_wrapper .readonly input").attr('readonly','readonly');
					
		$('.readonly').each(function() {		
			$(this).append( '<div class="unclick"></div>' );
		});
				
	});