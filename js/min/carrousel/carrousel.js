!function(t){t(document).ready(function(){var e,a,n=t(".carrousel .owl-carousel");0<n.length&&n.owlCarousel({loop:!0,nav:!0,navText:['<span><<span class="screen-reader-text"> Référence précédente</span></span>','<span>><span class="screen-reader-text">Référence suivante <span></span>'],dots:!(n=200),autoplay:!0,autoplayTimeout:5e3,autoplaySpeed:2e3,autoplayHoverPause:!0,center:!0,margin:10,onInitialized:function(e){t(".owl-nav button").removeAttr("role")},stagePadding:a=120,responsive:{0:{items:1,stagePadding:a,nav:!(a=100)},500:{items:2,stagePadding:150,nav:!(e=170)},768:{items:2,stagePadding:e,nav:!0},1024:{items:3,stagePadding:a,nav:!0},1400:{items:3,stagePadding:n,nav:!0}}})})}(jQuery);