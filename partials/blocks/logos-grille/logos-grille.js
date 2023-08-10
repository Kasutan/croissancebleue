(function($) {

	$( document ).ready(function() {
		/*--------------------------------------------------------------
		# Pagination pour la grille de logo 
		https://listjs.com/docs/
		--------------------------------------------------------------*/
		var width=$(window).width();
		var page=8;
		var logos=$('.logos');
		var delai=$(logos).attr('data-delai');
		if(width < 768) {
			page=8;
		} else if(width < 1440 ) {
			page=12;
		} else {
			page=15;
		}
		var optionsListe = {
			valueNames: ['logo'],
			page: page,
			pagination: [{
				name: "paginationLogos",
				innerWindow : 5, //nbre de dots visibles
				outerWindow: 5, //nbre de dots visibles
			}]
		};
	
		var listePosts = new List('logos-avec-pagination', optionsListe);

		//Figer la hauteur du bloc avec le nombre maxi d'éléments
		var height=$(logos).outerHeight();
		$(logos).css('height',height+'px');

		//Défilement auto
		setInterval(defileAuto,delai);

		function defileAuto() {
			let active=$('.pagination li.active');
			let suivant=$(active).next();
			
			if(suivant.length == 0) {
				//On est à la dernière page, la suivante = la première
				suivant=$('.pagination li:first-of-type');
			}

			//Effet de transition
			$(logos).addClass('js-opaque');
			setTimeout(function(){
				$(suivant).click();
				$(logos).removeClass('js-opaque');
			},500);
		

		}


	}); //fin document ready
})( jQuery );

