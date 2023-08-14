//https://owlcarousel2.github.io/OwlCarousel2/docs/api-options.html

(function($) {

	$( document ).ready(function() {
		$('.equipier .toggle').click(function (e) { 
			var volet=$('#'+$(this).attr('aria-controls'));
			if($(this).attr('aria-expanded')=="false"){
				//On ferme tous les volets
				$('.equipier .toggle').attr('aria-expanded','false');
				$('.equipier .volet').slideUp('slow');
				
				//On ouvre celui-ci
				$(this).attr('aria-expanded','true');
				$(volet).slideDown('slow');
			} else {
				$(this).attr('aria-expanded','false');
				$(volet).slideUp('slow');
			}
			
		});
	}); //fin document ready
})( jQuery );