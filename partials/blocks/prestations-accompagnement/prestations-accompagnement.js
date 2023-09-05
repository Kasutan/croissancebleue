//https://owlcarousel2.github.io/OwlCarousel2/docs/api-options.html

(function($) {

	$( document ).ready(function() {
		var width=$(window).width();
		var titres=$('.prestations-accompagnement .titre');
		console.log(width);
		if(titres.length > 0 && width >=1024) {
			uniformiseH(titres);
		}

		var intros=$('.prestations-accompagnement .intro-col');
		if(intros.length > 0 && width >=1024) {
			uniformiseH(intros);
		}

		function uniformiseH(items) {
			var maxH=0;
			$.each(items,function(index,item) {
				if($(item).height() > maxH) {
					maxH=$(item).height();
				}
			});
			$(items).css('height',maxH+'px');
		}
	}); //fin document ready
})( jQuery );