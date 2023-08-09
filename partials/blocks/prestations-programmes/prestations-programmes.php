<?php 
/**
* Template pour le bloc prestations-programmes
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
$marque=wp_kses_post( get_field('marque') );
$texte=wp_kses_post( get_field('texte') );
$encart=wp_kses_post( get_field('encart') );
$image=esc_attr(get_field('image'));


printf('<section class="acf prestations-programmes %s">', $className);
	echo '<div class="image-wrap">';
		if($image) printf('<div class="image">%s</div>',wp_get_attachment_image($image,'large'));
		if($encart) printf('<p class="encart desktop">%s</p>',$encart);
	echo '</div>';

	echo '<div class="texte-wrap">';
		printf('<h2 class="titre-section">%s</h2>',$titre);
		if($encart) {
			printf('<p class="encart mobile">%s</p>',$encart);
		}
		if($marque) {
			printf('<p class="marque">%s</p>',$marque);
		}
		if($texte) {
			printf('<div class="texte">%s</div>',$texte);
		}
	echo '</div>';

echo '</section>';