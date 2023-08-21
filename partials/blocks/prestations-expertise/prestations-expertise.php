<?php 
/**
* Template pour le bloc prestations-expertise
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


printf('<section class="acf prestations-expertise decor-top %s">', $className);
	printf('<h2 class="titre-section">%s</h2>',$titre_section);

	if(have_rows('expertises')) {
		echo '<ul class="expertises">';
		while(have_rows('expertises')) {
			the_row();
			$texte=wp_kses_post(get_sub_field('texte'));
			if(function_exists('kasutan_make_list')) {
				$texte=kasutan_make_list($texte);
			}
			$titre=wp_kses_post(get_sub_field('titre'));
			$picto=esc_attr(get_sub_field('picto'));
			echo '<li class="expertise">';
				printf('<div class="picto">%s</div>',wp_get_attachment_image($picto));
				printf('<h3 class="titre">%s</h3>',$titre);
				printf('<div class="texte">%s</div>',$texte);
			echo '</li>';
		}
		echo '</ul>';
	}

echo '</section>';