<?php 
/**
* Template pour le bloc logos-grille
*
* @param   array $block The block settings and attributes.
* @param   string $content The block inner HTML (empty).
* @param   bool $is_preview True during AJAX preview.
* @param   (int|string) $post_id The post ID this block is saved to.
*/


if(array_key_exists('className',$block)) {
	$className=esc_attr($block["className"]);
} else $className='';


$titre=wp_kses_post( get_field('titre') );
$intro=wp_kses_post( get_field('intro') );
$label=wp_kses_post( get_field('label') );
$lignes=intval(esc_attr(get_field('lignes')));


$logos=get_field('logos'); //champ ACF galerie

if(!empty($logos)) :
	printf('<section class="acf logos-grille %s">', $className);
		
		printf('<h2 class="titre-section">%s</h2>',$titre);
		if($intro) {
			printf('<p class="intro ">%s</p>',$intro);
		}
	
		printf('<ul class="logos list" data-lignes="%s">',$lignes);
			foreach($logos as $logo) {
				printf('<li class="logo">%s</li>',wp_get_attachment_image($logo,'medium'));
			}
		echo '</ul>';

		if(count($logos)> $lignes * 5 && $label) {
			printf('<div class="bouton-wrap"><button id="affiche-tous" class="bouton affiche-tous">%s</button></div>',$label);
		} 

	echo '</section>';
endif;