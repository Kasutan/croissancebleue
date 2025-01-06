<?php
/**
 * Fonction utilitaire pour obtenir une chaine traduite
*/
if(!function_exists('kpll__') ) {
	function kpll__($chaine) {
		if(function_exists('pll__')) {
			$chaine=pll__($chaine);
		}
		return $chaine;
	}
}


/**
 * Enregistrer chaines à traduire dans Polylang
*/

if(function_exists("pll_register_string")) {
	$chaines=array(
		"Aller directement au contenu",
		"Retour en haut de la page",
		"Entrez votre recherche",
		"Rechercher",
		"Mot clé",
		"Contenu introuvable",
		"Désolé, aucun résultat n'a été trouvé. Voulez-vous essayer avec des mots-clés différents ?",
		"Ce contenu n'existe pas. Voulez-vous essayer une recherche ?",
		"Profil LinkedIn",
		'Publié le ',
		"Lire la page",
		"Lire l'article"
	);

	foreach ($chaines as $string) {
		pll_register_string('croissancebleue', $string,'croissancebleue');
	}
}

/**
 * Intercepter les chaines de certains plugins
*/
/*
add_filter( 'gettext', function($translated, $original, $domain) {
	$chaines=array(	
		
	);

	$domaines=array();


	if(in_array($domain,$domaines) && in_array($original,$chaines)) {
		return kpll__($original);
	}

	return $translated;
}, 10, 3);*/