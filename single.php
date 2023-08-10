<?php
/**
 * Single Post
 *
 * @package      EAStarter
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

//Body class
function kasutan_single_body_class( $classes ) {
	if(!has_post_thumbnail()) {
		$classes[] = 'no-thumbnail';
	}
	return $classes;
}
add_filter( 'body_class', 'kasutan_single_body_class' );

// Bannière avec image, fil d'ariane, titre et extrait
add_action( 'tha_entry_top', 'kasutan_single_banniere', 7 );



//Métas insérées avant le contenu
add_action('tha_entry_content_before', 'kasutan_affiche_metas_single');


// Build the page
require get_template_directory() . '/index.php';
