<?php 
/**
* Template pour le bloc agence-equipe
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
$intro=wp_kses_post( get_field('intro') );
$image=esc_attr(get_field('image'));


printf('<section class="acf agence-equipe %s">', $className);
	echo '<div class="intro-wrap">';
		printf('<h2 class="titre-section">%s</h2>',$titre_section);
		if($intro) {
			printf('<p class="intro">%s</p>',$intro);
		}
		if($image) {
			printf('<div class="image">%s</div>',wp_get_attachment_image($image,'large'));
		}
	echo '</div>';


	if(have_rows('equipiers')) {
		echo '<ul class="equipiers">';
		while(have_rows('equipiers')) {
			the_row();
			$bio=wp_kses_post(get_sub_field('bio'));
			$nom=wp_kses_post(get_sub_field('nom'));
			$role1=wp_kses_post(get_sub_field('role_1'));
			$role2=wp_kses_post(get_sub_field('role_2'));
			$lien=esc_url(get_sub_field('lien'));
			$id='eq-'.rand(0,1000);
			echo '<li class="equipier">';
				echo '<div class="summary">';
					printf('<h3 class="nom">%s</h3>',$nom);
					if($lien) {
						printf('<a href="%s" target="_blank" rel="noopener noreferrer" title="Consulter le profil LinkedIn">',$lien);
						?>
							<svg version="1.1" width="45" height="46" xmlns="http://www.w3.org/2000/svg"><defs ></defs><g transform="translate(-19.8 -16.87)" fill="none"><ellipse cx="42.3" cy="39.87" rx="22.5" ry="23" /><ellipse cx="42.3" cy="39.87" rx="21.5" ry="22" stroke="#000" stroke-width="2"/></g><g  transform="translate(-19.8 -16.87)"><path  d="M34.99 35.64h3.22v9.68h-3.22z"/><path  d="M48.8 36.52a3.492 3.492 0 00-2.69-1.11c-.38 0-.76.05-1.12.15-.31.09-.6.23-.85.42-.38.28-.69.63-.94 1.02v-1.38h-3.21v.47c.02.31.02 1.28.02 2.89s0 3.72-.02 6.32h3.21v-5.4c0-.27.03-.54.11-.79.13-.33.35-.61.62-.83.29-.23.66-.35 1.03-.34.49-.04.95.18 1.24.58.29.48.43 1.04.4 1.61v5.18h3.21v-5.55c.08-1.17-.28-2.33-1.02-3.25z"/><path d="M36.63 30.98c-.48-.02-.96.15-1.31.47-.33.31-.51.75-.5 1.2-.01.45.17.88.49 1.19.35.33.81.5 1.29.48h.02c.49.02.96-.15 1.32-.48.33-.31.51-.74.49-1.19 0-.45-.17-.89-.5-1.2-.35-.33-.82-.5-1.3-.47z"/></g></svg>
						<?php
						echo '</a>';
					}
						
					printf('<button class="toggle" aria-controls="%s" aria-expanded="false" aria-label="Ouvrir le volet pour lire la bio de %s"><span class="picto">',$id,$nom);
						?>
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.969 18.81"><path d="M87.666,41.75l7.407-7.407a.593.593,0,0,0,0-.867l-.942-.942a.592.592,0,0,0-.867,0l-8.783,8.783a.593.593,0,0,0,0,.867l8.783,8.783a.592.592,0,0,0,.867,0l.942-.942a.593.593,0,0,0,0-.867Z" transform="translate(95.262 51.155) rotate(180)" fill="#000"/></svg>
						<?php
					echo '</span></button>';
				echo '</div>';

				printf('<div class="volet" id="%s">',$id);
					if($role1) printf('<p class="role role1">%s</p>',$role1);
					if($role2) printf('<p class="role role2">%s</p>',$role2);
					if($bio) printf('<p class="bio">%s</p>',$bio);
				echo '</div>';
			echo '</li>';
		}
		echo '</ul>';
	}

echo '</section>';