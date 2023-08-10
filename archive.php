<?php
/**
 * Archive
 *
 * @package      EAStarter
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/


/**
 * Body Class
 *
 */
function ea_archive_body_class( $classes ) {
	$classes[] = 'archive';
	return $classes;
}
add_filter( 'body_class', 'ea_archive_body_class' );

/**
 * Archive Header
 *
 */
add_action( 'tha_content_while_before', 'ea_archive_header' );
function ea_archive_header() {




	echo '<header class="entry-header">';
	do_action ('ea_archive_header_before' );
	do_action ('ea_archive_header_after' );
	echo '</header>';

	echo '<div class="container">';

		printf('<div id="archive-avec-pagination">');
			echo '<ul class="loop list">';
		

}


// Bannière avec titre, sur-titre et décors
add_action( 'ea_archive_header_before', 'kasutan_page_banniere', 7 );

// Fermer balise loop
add_action( 'tha_content_while_after', 'ea_archive_while_after',10 );
function ea_archive_while_after() {
			echo '</ul> <!--end .loop-->';
		echo '<ul class="pagination"></ul>';
		echo '</div>'; // end #archive-avec-pagination
	echo '</div>'; //end .container
}
// Build the page
require get_template_directory() . '/index.php';
