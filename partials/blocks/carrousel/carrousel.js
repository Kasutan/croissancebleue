//https://owlcarousel2.github.io/OwlCarousel2/docs/api-options.html

(function($) {

	$( document ).ready(function() {
		var owl = $(".carrousel .owl-carousel"); 
		if(owl.length > 0) {
			var items= {
				xsm : 1,
				sm : 2,
				md : 2,
				lg : 3,
				xl : 3,
			}

			var padding= {
				xsm : 120,
				sm : 150,
				md : 170,
				lg : 100,
				xl:200
			}
			 
			owl.owlCarousel({
				loop:true,
				nav : true,
				navText:['<span><<span class="screen-reader-text"> Référence précédente</span></span>','<span>><span class="screen-reader-text">Référence suivante <span></span>'],
				dots : false,
				autoplay:true,
				autoplayTimeout:5000,
				autoplaySpeed:2000,
				autoplayHoverPause:true,
				center: true,
				margin:10,
				//slideBy:'page',
				//checkVisible: false,
				onInitialized: accessibleNav,
				stagePadding: 120, //pour voir en partie les logos voisins
				responsive : {
					0 : {
						items:items.xsm,
						stagePadding:padding.xsm,
						nav:false
					},
					500 : {
						items:items.sm,
						stagePadding:padding.sm,
						nav:false,
					},
					768 : {
						items:items.md,
						stagePadding:padding.md,
						nav:true
					},
					1024 : {
						items:items.lg,
						stagePadding:padding.lg,
						nav:true
					},
					1400 : {
						items:items.xl,
						stagePadding:padding.xl,
						nav:true
					}
				}
			});
		}

		function accessibleNav(e) {
			/*$('.owl-dot span').addClass('screen-reader-text');
			$('.owl-dot span').html('Afficher le groupe de logos suivant');*/
			//Role incorrect d'après Axe
			$('.owl-nav button').removeAttr('role');

		}
	}); //fin document ready
})( jQuery );