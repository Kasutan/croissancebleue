<?php 
/**
* Template pour le bloc ecosysteme-partenaires
*
* @param   array $block The block settings and attributes.
* @param   string $content The block inner HTML (empty).
* @param   bool $is_preview True during AJAX preview.
* @param   (int|string) $post_id The post ID this block is saved to.
*/


if(array_key_exists('className',$block)) {
	$className=esc_attr($block["className"]);
} else $className='';


$titre_section=wp_kses_post( get_field('titre_section') );
$intro=wp_kses_post( get_field('intro') );


printf('<section class="acf ecosysteme-partenaires %s">', $className);
	printf('<h2 class="titre-section">%s</h2>',$titre_section);
	if($intro) printf('<p class="intro">%s</p>',$intro);
	

	if(have_rows('colonnes')) :
		echo '<ul class="colonnes">';
		while(have_rows('colonnes')) : the_row();
			$titre=wp_kses_post( get_sub_field('titre') );
			$texte=wp_kses_post( get_sub_field('texte') );
			echo '<li class="colonne">';
				printf('<h3 class="titre">%s</h3>',$titre);
				printf('<div class="texte">%s</div>',$texte);
			echo '</li>';
		endwhile;
		echo '</ul>';
	endif;

echo '</section>';