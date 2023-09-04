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
				nav : false,
				navText:['<span><<span class="screen-reader-text"> Référence précédente</span></span>','<span>><span class="screen-reader-text">Référence suivante <span></span>'],
				dots : true,
				dotsEach:false,
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
			$('.owl-dot').html('<span class="screen-reader-text">Afficher le groupe de logos suivant</span>');
			//Role incorrect d'après Axe
			$('.owl-nav button').removeAttr('role');
			$.each($('.owl-dot'),function(index,item) {
				$(item).attr('data-index',index);
			});
		}

		function activeDots(e) {
			/*var indexCourant=$('.owl-dot.active').attr('data-index');
			$('.owl-dot').removeClass('voisin-actif');
			for (var i=1; i<=4; i++) {
				var indexVoisin=indexCourant - i;
				if(i>=0) {
					$('.owl-dot[data-index='+indexVoisin+']').addClass('voisin-actif');
				}
			}*/
		}
	}); //fin document ready
})( jQuery );