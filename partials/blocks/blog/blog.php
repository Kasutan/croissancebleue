<?php 
/**
* Template pour le bloc Blog
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
$sous_titre=wp_kses_post( get_field('sous_titre') );
$label_bouton=wp_kses_post( get_field('label_bouton') );

$args=array(
	'posts_per_page' => '3',
	'orderby' => 'date',
	'order' => 'DESC',
);


$articles=new WP_Query($args);

if($articles->have_posts(  )) {
	printf('<section class="acf-blog %s">', $className);

		printf('<h2 class="titre-section">%s</h2>',$titre_section);

			echo '<ul class="loop">';
			$n=1;
			//forcer loop à s'arrêter à  (même s'il y a un sticky post)
			while ( $articles->have_posts() && $n<=3) {
				$articles->the_post();
				get_template_part( 'partials/archive');
				$n++;
			}
			echo '</ul>';
		wp_reset_postdata();

		$url=get_permalink( get_option( 'page_for_posts' ));
		printf('<a href="%s" class="bouton">Voir plus</a>',$url);


	echo '</section>';
}
