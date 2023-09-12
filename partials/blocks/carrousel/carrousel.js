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
				xl : 4,
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
				center: false,
				margin:10,
				stagePadding: 0,
				//checkVisible: false,
				onInitialized: accessibleNav,
				//onChanged: activeDots,
				slideBy:1,
				responsive : {
					0 : {
						items:items.xsm,
						
					},
					500 : {
						items:items.sm,

					},
					768 : {
						items:items.md,

					},
					1024 : {
						items:items.lg,

					},
					1400 : {
						items:items.xl,

					}
				}
			});
		}

		function accessibleNav(e) {
			//Role incorrect d'après Axe
			$('.owl-nav button').removeAttr('role');
		}

		
	}); //fin document ready
})( jQuery );