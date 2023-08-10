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
$delai=esc_attr(get_field('delai'));
if(!$delai) {
	$delai=6000;
} else {
	$delai=$delai*1000;
}

$logos=get_field('logos'); //champ ACF galerie

if(!empty($logos)) :
	printf('<section class="acf logos-grille %s">', $className);
		
		printf('<h2 class="titre-section">%s</h2>',$titre);
		if($intro) {
			printf('<p class="intro ">%s</p>',$intro);
		}
	
		echo '<div  id="logos-avec-pagination">';
			printf('<ul class="logos list" data-delai="%s">',$delai);
				foreach($logos as $logo) {
					printf('<li class="logo">%s</li>',wp_get_attachment_image($logo,'medium'));
				}
			echo '</ul>';

			echo '<ul class="pagination"></ul>';
		echo '</div>';

	echo '</section>';
endif;