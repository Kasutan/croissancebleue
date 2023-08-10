<?php
/**
 * Archive partial - search results
 *
**/

$post_type=get_post_type();
$tag='li';
$post_id=get_the_ID();
$titre=get_the_title($post_id);
$link=get_the_permalink($post_id);

if($post_type==='page') {
	$label_suite="Lire la page";
} else {
	$label_suite="Lire l'article";
}

printf('<%s class="vignette">',$tag);
	if(function_exists('kasutan_affiche_image_vignette')) {
		kasutan_affiche_image_vignette($post_id,$link);
	}

	echo '<div class="texte">';

		$date=get_the_date('',$post_id);
		printf('<p class="date">%s</p>',$date);

		printf('<h2 class="titre-item"><a href="%s">%s</a></h2>',$link,$titre);
			
		printf('<a class="extrait" href="%s">%s</a>',$link,get_the_excerpt($post_id));

		printf('<div class="suite"><a href="%s">%s<span class="screen-reader-text"> %s</span></a></div>',$link,$label_suite,$titre);
	echo '</div>';

	/**Pour vignette en position top post */
	printf('<h2 class="titre-item top-post"><a href="%s">%s</a></h2>',$link,$titre);
			
	printf('<a class="extrait top-post" href="%s">%s</a>',$link,get_the_excerpt($post_id));

	printf('<div class="suite top-post"><a href="%s">%s<span class="screen-reader-text"> %s</span></a></div>',$link,$label_suite,$titre);
	
printf('</%s>',$tag);