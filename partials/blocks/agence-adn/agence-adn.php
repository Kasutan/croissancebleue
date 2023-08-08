<?php 
/**
* Template pour le bloc agence-adn
*
* @param   array $block The block settings and attributes.
* @param   string $content The block inner HTML (empty).
* @param   bool $is_preview True during AJAX preview.
* @param   (int|string) $post_id The post ID this block is saved to.
*/


if(array_key_exists('className',$block)) {
	$className=esc_attr($block["className"]);
} else $className='';


$titre_section=wp_kses_post( get_field('titre') );
$intro=wp_kses_post( get_field('intro') );


printf('<section class="acf agence-adn decor-top %s">', $className);
	echo '<div class="texte-wrap">';
		printf('<h2 class="titre-section">%s</h2>',$titre_section);
		if($intro) {
			printf('<p class="intro">%s</p>',$intro);
		}
	echo '</div>';


	if(have_rows('valeurs')) {
		echo '<ul class="valeurs">';
		while(have_rows('valeurs')) {
			the_row();
			$texte=wp_kses_post(get_sub_field('texte'));
			$titre=wp_kses_post(get_sub_field('titre'));
			$picto=esc_attr(get_sub_field('picto'));
			echo '<li class="valeur">';
				printf('<div class="picto">%s</div>',wp_get_attachment_image($picto));
				printf('<h3 class="titre">%s</h3>',$titre);
				printf('<p class="texte">%s</p>',$texte);
			echo '</li>';
		}
		echo '</ul>';
	}

echo '</section>';