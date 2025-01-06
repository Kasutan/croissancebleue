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


	echo '<div class="main-footer">';
	
		if($logo) {
			$url=get_option( 'home' );
			if(KPLL && pll_current_language()=='en') {
				$url="/en";
			}
			printf('<a href="%s" class="logo-footer"><span class="screen-reader-text">Aller à la page d\'accueil</span>%s</a>',$url,wp_get_attachment_image($logo,'medium'));
		}

		echo '<ul class="contact">';
		if($email) {
			echo '<li><span class="picto"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg></span>';
				printf('<a href="mailto:%s" class="email" >%s</a>',$email,$email);
			echo '</li>';

		}

		if(function_exists('kasutan_telephone')) {
			echo '<li><span class="picto"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg></span>';
				kasutan_telephone() ;
			echo '</li>';
		}

		if($adresse) {
			echo '<li><span class="picto"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg></span>';
				printf('<span class="adresse">%s</span>',$adresse);
		echo '</li>';
		}


		if(function_exists('kasutan_linkedin')) {
			echo '<li><span class="picto"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/></svg></span>';
				kasutan_linkedin('footer') ;
			echo '</li>';
		}

		echo '</ul>';


		$i=2;
		if( has_nav_menu( 'footer-'.$i ) ) {
			wp_nav_menu( array( 'theme_location' => 'footer-'.$i, 'menu_id' => 'footer-'.$i, 'container_class' => 'nav-footer' ) );
		}

	
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
		?>
		<div id="wcb" class="carbonbadge wcb-d"></div>
		<script src="https://unpkg.com/website-carbon-badges@1.1.3/b.min.js" defer></script>
		<?php
	echo '</div>';

}