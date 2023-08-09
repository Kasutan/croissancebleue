<?php 
/**
* Template pour le bloc ecosysteme-mecenat
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
$texte=wp_kses_post( get_field('texte') );
$cta=wp_kses_post( get_field('cta') );
$intro=wp_kses_post( get_field('intro') );
$image1=esc_attr(get_field('image1'));
$image2=esc_attr(get_field('image2'));


printf('<section class="acf ecosysteme-mecenat %s">', $className);
	echo '<div class="texte-wrap">';
		printf('<h2 class="titre-section">%s</h2>',$titre);
		if($intro) {
			printf('<p class="intro ">%s</p>',$intro);
		}
	
		if($texte) printf('<div class="texte">%s</div>',$texte);

		if($cta) printf('<p class="cta"><strong>%s</strong></p>',$cta);

	echo '</div>';

	echo '<div class="image-wrap">';
		if($image1) printf('<div class="image image-1">%s</div>',wp_get_attachment_image($image1,'large'));
		if($image2) printf('<div class="image image-2">%s</div>',wp_get_attachment_image($image2,'medium'));
	echo '</div>';

echo '</section>';