<?php
/**
 * Site Header
 *
 * @package      EAStarter
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

echo '<!DOCTYPE html>';
tha_html_before();
echo '<html ' . get_language_attributes() . '>';

echo '<head>';
	echo '<meta charset="' . get_bloginfo( 'charset' ) . '">'; // En premier pour validité HTML W3C
	tha_head_top();
	wp_head();
	tha_head_bottom();
echo '</head>';

echo '<body class="' . join( ' ', get_body_class() ) . '">';
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
tha_body_top();
echo '<div class="site-container">';
	

	tha_header_before();
	echo '<header class="site-header">';
	echo '<a class="skip-link screen-reader-text" href="#main-content">' . kpll__( 'Aller directement au contenu') . '</a>';
		tha_header_top();

		echo '<div class="title-area">';
		$logo_tag='p';
		
		if(has_custom_logo()) {
			printf('<%s class="site-title">%s<span class="screen-reader-text">%s</span></%s>',
				$logo_tag,
				get_custom_logo(),	
				get_bloginfo( 'name'),
				$logo_tag,	
			);
		} else {
			printf('<%s class="site-title">%s</%s>',
				$logo_tag,
				get_bloginfo( 'name'),
				$logo_tag,	
			);
		}
			
		echo '</div>';

		tha_header_bottom();
	echo '</header>';
	tha_header_after();
	printf('<div class="%s" id="main-content"><span id="haut-page"></span>',apply_filters('kasutan_site_inner_class','site-inner'));
