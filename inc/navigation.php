<?php
/**
 * Navigation
 *
 * @package      EAStarter
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/
/**
* Generate a class attribute and an AMP class attribute binding.
*
* @param string $default Default class value.
* @param string $active  Value when the state enabled.
* @param string $state   State variable to toggle based on.
* @return string HTML attributes.
*/

/* walker for primary menu sub nav */
class etcode_sublevel_walker extends Walker_Nav_Menu
{
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .=sprintf('<button class="ouvrir-sous-menu picto"><span class="screen-reader-text">Montrer ou masquer le sous-menu</span><span class="picto-angle">%s</span></button><ul class="sub-menu">',kasutan_picto(array('icon'=>'triangle')) );
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "</ul>";
	}
}


/**
* Navigation
*
*/
add_action( 'tha_header_bottom', 'ea_site_header', 10 );


function ea_site_header() {
	echo '<div class="header-navigation">';


		//Navigation mobile
		kasutan_mobile_nav();

		//Navigation desktop
		echo '<nav id="site-navigation" class="nav-main" aria-label="menu principal">';
			if( has_nav_menu( 'primary' ) ) {
				if( class_exists('etcode_sublevel_walker') ) {
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'walker' => new etcode_sublevel_walker,
						'container_class' => 'nav-primary'
					) );
				} else {
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container_class' => 'nav-primary'
					) );
				}

			}
		echo '</nav>';
	echo '</div>';
}


function kasutan_mobile_nav() {
	$fav=false;
	if(function_exists('get_field')) {
		$fav=esc_attr(get_field('cb_volet_logo','option'));
	}
	?>
	<button class="menu-toggle" type="button" id="menu-toggle" aria-controls="volet-navigation"  aria-label="Menu">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.68 22.68"><defs><style>.menu-cls-1{fill:none;stroke:#171715;stroke-linecap:round;stroke-miterlimit:10;stroke-width:2px;}</style></defs><g><line class="menu-cls-1" x1="3.71" y1="5.63" x2="15.25" y2="5.63"/><line class="menu-cls-1" x1="8.42" y1="11.17" x2="19.97" y2="11.17"/><line class="menu-cls-1" x1="3.71" y1="16.71" x2="15.25" y2="16.71"/></g></svg>
	</button>

	<div class="volet-navigation"  id="volet-navigation">
		<?php

		//Favicon blanc
		if($fav) {
			$url=get_option( 'home' );
			printf('<a href="%s" class="logo">%s</a>',$url,wp_get_attachment_image($fav));
		}

		wp_nav_menu( array(
			'theme_location' => 'primary',
			'menu_id'        => 'menu-mobile',
			'menu_class'=>'menu-mobile',
		) );

		if(function_exists('kasutan_linkedin')) {
			kasutan_linkedin() ;
		}

		if(function_exists('kasutan_telephone')) {
			kasutan_telephone() ;
		}


	echo '</div>'; //Fin volet navigation
}


/**
 * Archive Paginated Navigation
 *
 */
add_action( 'tha_content_while_after', 'kasutan_archive_paginated_navigation',20 );
function kasutan_archive_paginated_navigation() {
	if( ! is_singular() )
	the_posts_pagination();
}

