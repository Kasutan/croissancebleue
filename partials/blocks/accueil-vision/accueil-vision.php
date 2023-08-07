<?php 
/**
* Template pour le bloc accueil-vision
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
$citation=wp_kses_post( get_field('citation') );
$image=esc_attr(get_field('image'));
$lien=get_field('lien');


printf('<section class="acf accueil-vision %s">', $className);

	printf('<h2 class="titre-section mobile">%s</h2>',$titre);

	echo '<div class="image-wrap">';
		if($image) printf('<div class="image">%s</div>',wp_get_attachment_image($image,'large'));
		if($citation) printf('<blockquote>%s</blockquote>',$citation);
	echo '</div>';

	echo '<div class="texte-wrap">';
		printf('<h2 class="titre-section desktop">%s</h2>',$titre);

		if($intro) {
			printf('<p class="intro">%s</p>',$intro);
		}

		if($lien) {
			$attr = $lien['target'] ? 'target="_blank" rel="noopener noreferrer"' : '';
			printf('<a href="%s" class="bouton" %s >%s</a>',$lien['url'],$attr,$lien['title']);
		}

	echo '</div>';

echo '</section>';
	