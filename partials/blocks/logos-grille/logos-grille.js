(function($) {

	$( document ).ready(function() {
	
		var width=$(window).width();
		var logos=$('.logo');
		var lignes=parseInt($('.logos').attr('data-lignes'));
		var montrer=6;
		if(width < 768) {
			montrer=2*lignes;
		} else if(width < 1024 ) {
			montrer=3*lignes;
		} else if(width < 1440 ) {
			montrer=4*lignes;
		} else {
			montrer=5*lignes;
		}

		//Au chargement de la page, cacher les logos au delà des X premières lignes
		$(logos).each(function(index,item) {
			if(index > montrer) {
				$(this).hide();
			}
		})

		//Au clic sur le bouton afficher tous, afficher tous les logos (avec un effet de transition)
		var bouton=	$('#affiche-tous');
		$(bouton).click(function(event) {
			$(logos).addClass('js-opaque');
			setTimeout(function(){
				$(logos).show();
				$(bouton).hide();
				$(logos).removeClass('js-opaque');
			},500);
		})
	
	}); //fin document ready
})( jQuery );

