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

function kasutan_linkedin($contexte='') {
	if(!function_exists('get_field')) {
		return;
	}
	$link=esc_url(get_field('cb_linkedin','option'));
	if(!$link) {
		return;
	}
	if($contexte=='footer') {
		printf('<a href="%s" class="linkedin" target="_blank" rel="noopener noreferrer" title="LinkedIn">Profil LinkedIn</a>',$link);
	} else {
		printf('<a href="%s" class="linkedin" target="_blank" rel="noopener noreferrer" title="LinkedIn">',$link);
	?>
		<svg version="1.1" width="45" height="46" xmlns="http://www.w3.org/2000/svg"><defs ><style >.lkd-cls-3{fill:#fff}</style></defs><g transform="translate(-19.8 -16.87)" fill="none"><ellipse cx="42.3" cy="39.87" rx="22.5" ry="23" /><ellipse cx="42.3" cy="39.87" rx="21.5" ry="22" stroke="#fff" stroke-width="2"/></g><g  transform="translate(-19.8 -16.87)"><path class="lkd-cls-3" d="M34.99 35.64h3.22v9.68h-3.22z"/><path  class="lkd-cls-3" d="M48.8 36.52a3.492 3.492 0 00-2.69-1.11c-.38 0-.76.05-1.12.15-.31.09-.6.23-.85.42-.38.28-.69.63-.94 1.02v-1.38h-3.21v.47c.02.31.02 1.28.02 2.89s0 3.72-.02 6.32h3.21v-5.4c0-.27.03-.54.11-.79.13-.33.35-.61.62-.83.29-.23.66-.35 1.03-.34.49-.04.95.18 1.24.58.29.48.43 1.04.4 1.61v5.18h3.21v-5.55c.08-1.17-.28-2.33-1.02-3.25z"/><path class="lkd-cls-3" d="M36.63 30.98c-.48-.02-.96.15-1.31.47-.33.31-.51.75-.5 1.2-.01.45.17.88.49 1.19.35.33.81.5 1.29.48h.02c.49.02.96-.15 1.32-.48.33-.31.51-.74.49-1.19 0-.45-.17-.89-.5-1.2-.35-.33-.82-.5-1.3-.47z"/></g></svg>
	</a>
	<?php
	}
	

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
		$titre=get_the_title($home_id);
	}

	if($titre) printf('<h1 class="titre">%s</h1>',$titre);

}

/**
* Image banniere pour les pages (sauf template simple), y compris les archives
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
		kasutan_page_titre(); //fonctionne aussi pour les archives !
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
	

		echo '<div class="textes mobile">';
			
			printf('<h1 class="titre">%s</h1>',$titre);
			if($texte) {
				printf('<div class="texte">%s</div>',$texte);
			}
			
		echo '</div>';

		printf('<div class="titre-wrap desktop"><h1 class="titre desktop" style="background-image:url(%s)">%s</h1></div>',$clip_url,$titre);

		if($texte) {
			printf('<div class="texte desktop">%s</div>',$texte);
		}
	echo '</div>';
	
}

/***
 * Page bannière pour la page d'accueil (avec un texte de part et d'autre du titre)
 */
function kasutan_front_page_banniere() {
	if(!function_exists('get_field')) {
		return;
	}
	//champs personnalisés liés à la page, affichés dans le BO seulement si applicables	
	$page_id=get_the_ID();
	$titre_seo=wp_kses_post( get_field('banniere_titre_seo',$page_id) );
	$texte_1=wp_kses_post( get_field('banniere_texte_1',$page_id) );
	$texte_2=wp_kses_post( get_field('banniere_texte_2',$page_id) );
	$texte_3=wp_kses_post( get_field('banniere_texte_3',$page_id) );
	$image_desktop=esc_attr( get_field('banniere_image_desktop',$page_id) );
	$image_mobile=esc_attr( get_field('banniere_image_mobile',$page_id) );
	$image_clip=esc_attr( get_field('banniere_image_clip',$page_id) );

	if(!$image_clip && $image_desktop) {
		$image_clip=$image_desktop;
	}
	if(!$image_mobile && $image_desktop) {
		$image_mobile=$image_desktop;
	}

	if(!$texte_2 || !$image_desktop) {
		kasutan_page_titre();
		return;
	}

	$clip_url=wp_get_attachment_image_url($image_clip, 'medium');


	printf('<div class="page-banniere pour-accueil">');
		echo '<div class="image mobile">';
			echo wp_get_attachment_image( $image_mobile, 'large',false,array('decoding'=>'async','loading'=>'eager'));
		echo '</div>';

	
		echo '<div class="image desktop">';
			echo wp_get_attachment_image( $image_desktop, 'banniere',false,array('decoding'=>'async','loading'=>'eager'));
		echo '</div>';
	

		printf('<h1 class="screen-reader-text">%s</h1>',$titre_seo);
		echo '<div class="textes mobile" aria-hidden="true">';
			if($texte_1) {
				printf('<div class="texte texte_1">%s</div>',$texte_1);
			}
			
			printf('<div class="h1 titre">%s</div>',$texte_2);
			if($texte_3) {
				printf('<div class="texte texte_3">%s</div>',$texte_3);
			}
			
		echo '</div>';

		if($texte_1) {
			printf('<div class="texte texte_1 desktop">%s</div>',$texte_1);
		}
		printf('<div class="titre-wrap desktop"><div class="h1 titre" style="background-image:url(%s)">%s</div></div>',$clip_url,$texte_2);
		
		if($texte_3) {
			printf('<div class="texte texte_3 desktop">%s</div>',$texte_3);
		}
	echo '</div>';
} 



/**
* Banniere pour les articles single
*
*/
function kasutan_single_banniere() {
	

	$titre=get_the_title();

	//Pour le fil d'ariane : couper le titre au premier espace après X caractères
	$limite=30;
	if(strlen($titre) > $limite) {
		$espace=strpos($titre,' ',$limite);
		$titre_coupe=substr($titre,0,$espace);
		$titre_coupe.='&mldr;'; //on ajoute le caractère pour l'ellipse
	} else {
		$titre_coupe=$titre;
	}



	printf('<div class="single-banniere">');
		if(has_post_thumbnail()) {
			echo '<div class="image">';
				the_post_thumbnail('banniere');
			echo '</div>';
		}
		
		$home_id=get_option('page_for_posts');
		printf('<p class="ariane"><a href="%s">%s</a> > %s</p>',
			get_the_permalink($home_id),
			get_the_title($home_id),
			$titre_coupe
		);

		echo '<div class="textes">';
			printf('<h1 class="titre">%s</h1>',$titre);
			if(has_excerpt()) {
				printf('<div class="extrait">%s</div>',get_the_excerpt());
			}
			
		echo '</div>';
	echo '</div>';
	
}

/**
* Afficher les métas dans les single article
*
*/
function kasutan_affiche_metas_single($post_id) {
	$autrice=get_the_author_meta('display_name');
	
	$image=false;
	if(function_exists('get_field')) {
		$id=get_the_author_meta('id');
		$image=esc_attr(get_field('photo','user_'.$id)); 
	}
	//Métas single
	echo '<div class="meta-single">';
		if($image) printf('<div class="image">%s</div>',wp_get_attachment_image($image));
		echo '<div class="textes">';
			printf('<p class="autrice">%s </p>',$autrice);
			printf('<p class="date">%s %s</p>',__('Publié le ','croissancebleue'),get_the_date());
		echo '</div>';
	echo '</div>';

}


/***
 * Post thumbnail cliquable avec fallback
 */
function kasutan_affiche_image_vignette($post_id,$link) {
	if(has_post_thumbnail()) { 
		printf('<a href="%s" class="image">%s</a>',$link,get_the_post_thumbnail( $post_id, 'medium'));
	} else if(function_exists('get_field')) {
		$defaut=esc_attr(get_field('vignette_defaut','option'));
		if($defaut) {
			printf('<a href="%s" class="image">%s</a>',$link,wp_get_attachment_image( $defaut, 'medium'));
		}
	}
}