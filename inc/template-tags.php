<?php
/**
 * Template Tags
 *
 * @package      EAStarter
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/


/**
* Affiche un lien vers la page LinkedIn de l'engtreprise
*
*/

function kasutan_linkedin() {
	if(!function_exists('get_field')) {
		return;
	}
	$link=esc_url(get_field('cb_linkedin','option'));
	if(!$link) {
		return;
	}
	printf('<a href="%s" class="linkedin" target="_blank" rel="noopener noreferrer" title="LinkedIn">',$link);
	?>
		<svg version="1.1" width="45" height="46" xmlns="http://www.w3.org/2000/svg"><defs ><style >.lkd-cls-3{fill:#fff}</style></defs><g transform="translate(-19.8 -16.87)" fill="none"><ellipse cx="42.3" cy="39.87" rx="22.5" ry="23" /><ellipse cx="42.3" cy="39.87" rx="21.5" ry="22" stroke="#fff" stroke-width="2"/></g><g  transform="translate(-19.8 -16.87)"><path class="lkd-cls-3" d="M34.99 35.64h3.22v9.68h-3.22z"/><path  class="lkd-cls-3" d="M48.8 36.52a3.492 3.492 0 00-2.69-1.11c-.38 0-.76.05-1.12.15-.31.09-.6.23-.85.42-.38.28-.69.63-.94 1.02v-1.38h-3.21v.47c.02.31.02 1.28.02 2.89s0 3.72-.02 6.32h3.21v-5.4c0-.27.03-.54.11-.79.13-.33.35-.61.62-.83.29-.23.66-.35 1.03-.34.49-.04.95.18 1.24.58.29.48.43 1.04.4 1.61v5.18h3.21v-5.55c.08-1.17-.28-2.33-1.02-3.25z"/><path class="lkd-cls-3" d="M36.63 30.98c-.48-.02-.96.15-1.31.47-.33.31-.51.75-.5 1.2-.01.45.17.88.49 1.19.35.33.81.5 1.29.48h.02c.49.02.96-.15 1.32-.48.33-.31.51-.74.49-1.19 0-.45-.17-.89-.5-1.2-.35-.33-.82-.5-1.3-.47z"/></g></svg>
	</a>
	<?php

}


/**
* Affiche un lien avec le numéro de tél de l'entreprise
*
*/

function kasutan_telephone() {
	if(!function_exists('get_field')) {
		return;
	}
	$tel=esc_attr(get_field('cb_telephone','option'));
	if(!$tel) {
		return;
	}
	$tel_formate=str_replace(' ','',$tel); //enlever espaces
	$tel_formate=substr($tel_formate,1); //enlever premier caractère
	$tel_formate='+33'.$tel_formate; //ajouter indicatif pays

	printf('<a href="tel:%s" class="tel" >%s</a>',$tel_formate,$tel);
}


/**
* Affiche le titre des contenus qui n'ont pas de bannière
*
*/
function kasutan_page_titre() {
	$titre=false;
	if(is_single() ) {
		$post_type=get_post_type();
		$titre=get_the_title();
	} if (is_search()) {
		$titre=__('Recherche :','croissancebleue').' '.get_search_query();
	} elseif (is_404()) {
		$titre= __('Page introuvable :','croissancebleue');
	} else if (is_page()) {
		$titre=get_the_title();
	} else if(is_category()) {
		$titre=strip_tags(single_cat_title( '', false ));
	} else if( is_tag() ) {
		$titre=strip_tags(single_tag_title( '', false ));
	} elseif (is_home()) {
		$home_id=get_option('page_for_posts');
		$titre=get_the_title($page_id);
	}

	if($titre) printf('<h1 class="titre">%s</h1>',$titre);

}

/**
* Image banniere pour les pages (sauf template simple)
*
*/
function kasutan_page_banniere($page_id=false,$use_defaut=false) {
	if(is_front_page(  )) {
		kasutan_front_page_banniere();
		return;
	}

	if(!function_exists('get_field')) {
		return;
	}
	//champs personnalisés liés à la page, affichés dans le BO seulement si applicables	
	$page_id=get_the_ID();
	$texte=wp_kses_post( get_field('banniere_texte',$page_id) );
	$image_desktop=esc_attr( get_field('banniere_image_desktop',$page_id) );
	$image_mobile=esc_attr( get_field('banniere_image_mobile',$page_id) );
	$image_clip=esc_attr( get_field('banniere_image_clip',$page_id) );

	if(!$image_clip && $image_desktop) {
		$image_clip=$image_desktop;
	}
	if(!$image_mobile && $image_desktop) {
		$image_mobile=$image_desktop;
	}

	if(!$texte || !$image_desktop) {
		kasutan_page_titre();
		return;
	}

	$titre=get_the_title();
	$clip_url=wp_get_attachment_image_url($image_clip, 'medium');


	printf('<div class="page-banniere">');
		echo '<div class="image mobile">';
			echo wp_get_attachment_image( $image_mobile, 'large',false,array('decoding'=>'async','loading'=>'eager'));
		echo '</div>';

	
		echo '<div class="image desktop">';
			echo wp_get_attachment_image( $image_desktop, 'banniere',false,array('decoding'=>'async','loading'=>'eager'));
		echo '</div>';
	

		echo '<div class="textes">';
			printf('<div class="titre-wrap"><h1 class="titre desktop" style="background-image:url(%s)">%s</h1></div>',$clip_url,$titre);
			printf('<h1 class="titre mobile">%s</h1>',$titre);
			if($texte) {
				printf('<div class="texte">%s</div>',$texte);
			}
			
		echo '</div>';
	echo '</div>';
	
}

/***
 * Page bannière pour la page d'accueil (simplifiée mais avec des images et un overlay)
 */
function kasutan_front_page_banniere() {
	if(!function_exists('get_field')) {
		return;
	}
	//champs personnalisés liés à la page, affichés dans le BO seulement si c'est la page d'accueil	
	$page_id=get_the_ID();
	$texte=wp_kses_post( get_field('banniere_texte',$page_id) );
	$image_desktop=esc_attr( get_field('banniere_image_desktop',$page_id) );
	$image_mobile=esc_attr( get_field('banniere_image_mobile',$page_id) );
	
	


	printf('<section class="page-banniere pour-accueil">');
		
		echo '<div class="fond-banniere">';
		//div qui overflow (avec images et décor diagonale)

			echo '<div class="image-accueil image-mobile">';
				echo wp_get_attachment_image( $image_mobile, 'large',false,array('decoding'=>'async','loading'=>'eager'));
			echo '</div>';

			
			echo '<div class="image-accueil image-desktop">';
				echo wp_get_attachment_image( $image_desktop, 'banniere',false,array('decoding'=>'async','loading'=>'eager'));
			echo '</div>';


			echo '<div class="decor-hero-bottom"></div>';	
			
		echo '</div>';

		printf('<h1 class="titre">%s</h1>',$texte);

	echo '</section>';	
} 

/**
* Image banniere pour les actus + utilisée aussi pour la recherche
*
*/
function kasutan_actus_banniere() {
	if(!function_exists('get_field')) {
		return;
	}


	if(is_single()) {
		//On est sur un post single, on vérifie s'il a sa propre image bannière
		$image_id=esc_attr(get_field('cb_banniere_image'));
		if(!$image_id) {
			//si le post n'a pas d'image bannière on utilise l'image par défaut
			$image_id=esc_attr(get_field('cb_bg_image','option'));//image par défaut
		}

		kasutan_page_banniere(get_the_ID());
		return;
	} 

	if(is_search()) {
		
		kasutan_page_banniere(false,true);
		return;
	}

	//On est sur une page d'archive, on affiche la bannière de la page des actualités
	$actus=get_option('page_for_posts'); 

	kasutan_page_banniere($actus);
}

/**
* Image mise en avant
*
*/
function kasutan_affiche_thumbnail_dans_contenu() {
	if(has_post_thumbnail()) {
		echo '<div class="thumbnail">';
			the_post_thumbnail( 'large');
		echo '</div>';
	}
}

/**
* Afficher le premier article de la page blog
*
*/
function kasutan_affiche_top_article() {
	$articles=new WP_Query(array(
		'post_type' => 'post',
		'posts_per_page' => 1,
		'orderby' => 'date',
		'order' => 'DESC'
	));
	if(!$articles->have_posts(  )) {
		return;
	}
	$n=1;
	while ( $articles->have_posts() && $n<=1) {
		$articles->the_post();
		$post_id=get_the_ID();
		$link=get_the_permalink();
		echo '<div class="top-post" style="position:relative">';
			printf('<a class="image" href="%s"><div class="image-wrap">',$link);
				echo get_the_post_thumbnail($post_id,'large');
				echo '</div>';
				if(is_sticky($post_id)) {
					printf('<div class="ruban">%s</div>',__('à la une','croissancebleue'));
				}
			echo '</a>';
			echo '<div class="col-texte">';
				printf('<h2 class="h3 titre-item"><a href="%s">%s</a></h2>',$link,get_the_title());
				kasutan_affiche_metas_article($post_id);
				printf('<a class="extrait" href="%s">%s</a>',$link,get_the_excerpt());
			echo '</div>';
		echo '</div>';
		$n++;
	}
	wp_reset_postdata();

}
/**
* Afficher les métas dans les vignettes article
*
*/
function kasutan_affiche_metas_article($post_id) {
	$date=get_the_date('d/m/Y',$post_id);
	$list=get_the_category_list('<span class="vir">, </span>', '', $post_id);
	echo '<p class="meta">';
		printf('<span class="date">%s <span class="sep">|</span></span>',$date);
		printf('<span class="cats">%s</span>',$list);
	echo '</p>';

}

/**
* Afficher un bouton avec le même markup que Gutenberg
*
*/

function kasutan_affiche_bouton($url,$label='',$classe='') {
	if(empty($label)) {
		$label=__('En savoir +','croissancebleue');
	}
	printf('<div class="wp-block-buttons is-content-justification-center is-layout-flex">
		<div class="wp-block-button %s">
			<a class="wp-block-button__link wp-element-button" href="%s">%s</a>
		</div>
	</div>', $classe,$url,$label);
}
