<?php 
/**
* Template pour le bloc accueil-accompagnement
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
$intro_section=wp_kses_post( get_field('intro_section') );
$lien=get_field('lien');


printf('<section class="acf accueil-accompagnement decor-top %s">', $className);
	printf('<h2 class="titre-section">%s</h2>',$titre_section);
	
	printf('<p class="intro">%s</p>',$intro_section);

	if(have_rows('services')) :
		echo '<ul class="services">';
		while(have_rows('services')) : the_row();
			$image=esc_attr(get_sub_field('picto'));
			$titre=wp_kses_post( get_sub_field('titre') );
			$chiffre=wp_kses_post( get_sub_field('chiffre') );
			$texte=wp_kses_post( get_sub_field('texte') );
			echo '<li class="service">';

				printf('<h3 class="titre">%s</h3>',$titre);

				echo '<div class="desktop">';
					printf('<div class="picto">%s</div>',wp_get_attachment_image($image));
					printf('<p class="texte"><strong class="chiffre">%s</strong><br>%s</p>',$chiffre,$texte);
				echo '</div>';
			
			echo '</li>';
		endwhile;
		echo '</ul>';
	endif;

	if($lien) {
		$attr = $lien['target'] ? 'target="_blank" rel="noopener noreferrer"' : '';
		printf('<a href="%s" class="bouton" %s >%s</a>',$lien['url'],$attr,$lien['title']);
	}
echo '</section>';