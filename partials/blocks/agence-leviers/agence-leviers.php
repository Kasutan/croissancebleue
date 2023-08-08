<?php 
/**
* Template pour le bloc agence-leviers
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
$encart=wp_kses_post( get_field('encart') );
$image1=esc_attr(get_field('image1'));
$image2=esc_attr(get_field('image2'));


printf('<section class="acf agence-leviers %s">', $className);
	echo '<div class="texte-wrap">';
		printf('<h2 class="titre-section">%s</h2>',$titre);
		if($encart) {
			printf('<p class="encart mobile">%s</p>',$encart);
		}
	
		if(have_rows('leviers')) {
			echo '<ul class="leviers">';
			while(have_rows('leviers')) {
				the_row();
				$texte=wp_kses_post(get_sub_field('texte'));
				printf('<li>%s</li>',$texte);
			}
			echo '</ul>';
		}
	echo '</div>';

	echo '<div class="image-wrap">';
		if($image1) printf('<div class="image image-1">%s</div>',wp_get_attachment_image($image1,'large'));
		if($image2) printf('<div class="image image-2">%s</div>',wp_get_attachment_image($image2,'medium'));
		if($encart) printf('<p class="encart desktop">%s</p>',$encart);
	echo '</div>';

echo '</section>';