<?php


/**
 * Formulaire newsletter + menus + logo Footer
 *
 */
add_action( 'tha_footer_top', 'kasutan_main_footer' );
function kasutan_main_footer() {

	$logo=$adresse=$titre=false;
	if(function_exists('get_field')) {
		$logo=esc_attr(get_field('cb_footer_logo','option'));		
		$adresse=wp_kses_post(get_field('cb_adresse','option'));
		$titre=wp_kses_post(get_field('cb_footer_col_titre','option'));
		$email=esc_attr(get_field('cb_email','option'));
		if($email) {
			$email=antispambot($email);
		}
	}


	echo '<div class="main-footer"><div class="colonnes-footer">';
	
	echo '<div class="col-1 col">';
		if($logo) {
			$url=get_option( 'home' );
			printf('<a href="%s" class="logo-footer"><span class="screen-reader-text">Aller à la page d\'accueil</span>%s</a>',$url,wp_get_attachment_image($logo,'medium'));
		}

		if($adresse) {
			printf('<p class="adresse">%s</p>',$adresse);
		}

		if(function_exists('kasutan_telephone')) {
			kasutan_telephone() ;
		}

		if($email) {
			printf('<a href="mailto:%s" class="email" >%s</a>',$email,$email);
		}

		if(function_exists('kasutan_linkedin')) {
			kasutan_linkedin() ;
		}

	echo '</div>';

	echo '<div class="col-2 col">';
		$i=2;
		if( has_nav_menu( 'footer-'.$i ) ) {
			wp_nav_menu( array( 'theme_location' => 'footer-'.$i, 'menu_id' => 'footer-'.$i, 'container_class' => 'nav-footer' ) );
		}
	echo '</div>';

	echo '<div class="col-3 col">';
		if($titre) printf('<p class="titre-col">%s</p>',$titre);

		if($email) {
			printf('<a href="mailto:%s" class="email" >%s</a>',$email,$email);
		}

		if(function_exists('kasutan_telephone')) {
			kasutan_telephone() ;
		}
		
		$i=3;
		if( has_nav_menu( 'footer-'.$i ) ) {
			wp_nav_menu( array( 'theme_location' => 'footer-'.$i, 'menu_id' => 'footer-'.$i, 'container_class' => 'nav-footer' ) );
		}
	echo '</div>';

	echo '</div>'; //fin colonnes-footer
	
	echo '</div>'; //fin main-footer

}


/**
* Copyright et liens légaux
*
*/
add_action( 'tha_footer_bottom', 'kasutan_copyright' );
function kasutan_copyright() {
	
	$texte=false;
	if(function_exists('get_field')) {
		$texte=wp_kses_post(get_field('cb_footer_copyright','option'));
	}

	echo '<div class="bottom-footer">';
		if($texte) printf('<p class="copyright">%s</p>',$texte);
		
		if( has_nav_menu( 'footer-copyright') ) {
			wp_nav_menu( array( 'theme_location' => 'footer-copyright', 'menu_id' => 'footer-copyright', 'container_class' => 'inline-footer' ) );
		}
	echo '</div>';
}