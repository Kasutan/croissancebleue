<?php
/**
 * Archive partial
 *
 * @package      EAStarter
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

//On récupère une éventuelle info sur le tag html passée en $args de get_template_part
$tag='li';
if(!empty($args) && array_key_exists('tag',$args)) {
	$tag=$args['tag'];
}
$class=get_post_type();
$post_id=get_the_ID();
$titre=get_the_title($post_id);
$link=get_the_permalink($post_id);


printf('<%s class="vignette %s">',$tag,$class);
	if(function_exists('kasutan_affiche_image_vignette')) {
		kasutan_affiche_image_vignette($post_id,$link);
	}

	echo '<div class="texte">';

		$date=get_the_date('',$post_id);
		printf('<p class="date">%s</p>',$date);

		printf('<h2 class="titre-item"><a href="%s">%s</a></h2>',$link,$titre);
			
		printf('<a class="extrait" href="%s">%s</a>',$link,get_the_excerpt($post_id));

		printf('<div class="suite"><a href="%s">%s<span class="screen-reader-text"> %s</span></a></div>',$link,kpll__("Lire l'article"),$titre);
	echo '</div>';

	/**Pour vignette en position top post */
	printf('<h2 class="titre-item top-post"><a href="%s">%s</a></h2>',$link,$titre);
			
	printf('<a class="extrait top-post" href="%s">%s</a>',$link,get_the_excerpt($post_id));

	printf('<div class="suite top-post"><a href="%s">%s<span class="screen-reader-text"> %s</span></a></div>',$link,kpll__("Lire l'article"),$titre);
	
printf('</%s>',$tag);

