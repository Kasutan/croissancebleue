<?php
/**
 * ACF Customizations
 *
 * @package      EAStarter
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

class BE_ACF_Customizations {

	public function __construct() {

		// Only allow fields to be edited on development
		if ( ! defined( 'WP_LOCAL_DEV' ) || ! WP_LOCAL_DEV ) {
			//add_filter( 'acf/settings/show_admin', '__return_false' );
		}

		// Save and sync fields.
		add_filter( 'acf/settings/save_json', array( $this, 'get_local_json_path' ) );
		add_filter( 'acf/settings/load_json', array( $this, 'add_local_json_path' ) );
		add_action( 'admin_init', array( $this, 'sync_fields_with_json' ) );

		// Register options page
		add_action( 'init', array( $this, 'register_options_page' ) );

		// Register Blocks
		add_filter( 'block_categories_all', array($this,'kasutan_block_categories'), 10, 2 );
		add_action('acf/init', array( $this, 'register_blocks' ) );

	}

	/**
	 * Define where the local JSON is saved.
	 *
	 * @return string
	 */
	public function get_local_json_path() {
		return get_template_directory() . '/acf-json';
	}

	/**
	 * Add our path for the local JSON.
	 *
	 * @param array $paths
	 *
	 * @return array
	 */
	public function add_local_json_path( $paths ) {
		$paths[] = get_template_directory() . '/acf-json';

		return $paths;
	}

	/**
	 * Automatically sync any JSON field configuration.
	 */
	public function sync_fields_with_json() {
		if ( defined( 'DOING_AJAX' ) || defined( 'DOING_CRON' ) )
			return;

		if ( ! function_exists( 'acf_get_field_groups' ) )
			return;

		$version = get_option( 'ea_acf_json_version' );

		if ( defined( 'KASUTAN_STARTER_VERSION' ) && version_compare( KASUTAN_STARTER_VERSION, $version ) ) {
			update_option( 'ea_acf_json_version', KASUTAN_STARTER_VERSION );
			$groups = acf_get_field_groups();

			if ( empty( $groups ) )
				return;

			$sync = array();
			foreach ( $groups as $group ) {
				$local    = acf_maybe_get( $group, 'local', false );
				$modified = acf_maybe_get( $group, 'modified', 0 );
				$private  = acf_maybe_get( $group, 'private', false );

				if ( $local !== 'json' || $private ) {
					// ignore DB / PHP / private field groups
					continue;
				}

				if ( ! $group['ID'] ) {
					$sync[ $group['key'] ] = $group;
				} elseif ( $modified && $modified > get_post_modified_time( 'U', true, $group['ID'], true ) ) {
					$sync[ $group['key'] ] = $group;
				}
			}

			if ( empty( $sync ) )
				return;

			foreach ( $sync as $key => $v ) {
				if ( acf_have_local_fields( $key ) ) {
					$sync[ $key ]['fields'] = acf_get_local_fields( $key );
				}
				acf_import_field_group( $sync[ $key ] );
			}
		}
	}

	/**
	 * Register Options Page
	 *
	 */
	function register_options_page() {
		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page(array(
				'page_title' 	=> 'Réglages du site Croissance Bleue',
				'menu_title'	=> 'Réglages du site Croissance Bleue',
				'menu_slug' 	=> 'site-settings',
				'capability'	=> 'edit_posts',
				'position' 		=> '2.5',
				'redirect'		=> false,
				'update_button' => 'Mettre à jour',
				'updated_message' => 'Réglages du site mis à jour',
				'capability' => 'manage_options',

			));
		}
	}

	/**
	* Enregistre une catégorie de blocs liée au thème
	*
	*/
	function kasutan_block_categories( $categories, $post ) {
		return array_merge(
			array(
				array(
					'slug' => 'croissancebleue',
					'title' => 'croissancebleue',
					'icon'  => 'star-filled',
				),
			),
			$categories
		);
	}

	function helper_register_block_type($slug,$titre,$description,$icon='star-filled',$js=false,$keywords=[], $multiple=true ){
		$keywords_from_slug=explode('-',$slug);
		$keywords=array_merge($keywords,$keywords_from_slug, array('croissance','bleue'));
		$args=[
			'name'            => $slug,
			'title'           => $titre,
			'description'     => $description,
			'render_template' => 'partials/blocks/'.$slug.'/'.$slug.'.php',
			'enqueue_style' => get_stylesheet_directory_uri() . '/partials/blocks/'.$slug.'/'.$slug.'.css',
			'category'        => 'croissancebleue',
			'icon'            => $icon, 
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>$multiple,
				'anchor' => true,
			),
			'keywords'        => $keywords
		];
		if($js) {
			$args['enqueue_script']=get_stylesheet_directory_uri() . '/js/min/'.$slug.'/'.$slug.'.js';
		}
		acf_register_block_type( $args);
	}
	

	/**
	 * Register Blocks
	 * @link https://www.billerickson.net/building-gutenberg-block-acf/#register-block
	 *
	 * Categories: common, formatting, layout, widgets, embed
	 * Dashicons: https://developer.wordpress.org/resource/dashicons/
	 * ACF Settings: https://www.advancedcustomfields.com/resources/acf_register_block/
	 */
	function register_blocks() {

		if( ! function_exists('acf_register_block_type') )
			return;

		/*********Bloc accueil-vision ***************/
		$this->helper_register_block_type( 
			'accueil-vision',
			'Bloc vision pour page Accueil',
			'Section avec titre, intro, citation, photo et bouton.',
			'star-filled', 
			false, 
			array('accueil', 'vision','citation')
		);

		/*********Bloc accueil-accompagnement ***************/
		$this->helper_register_block_type( 
			'accueil-accompagnement',
			'Bloc accompagnement pour page Accueil',
			'Section avec titre, intro, services avec pictos sur 3 colonnes et bouton.',
			'star-filled', 
			false, 
			array('accueil', 'service', 'accompagnement')
		);
		
		/*********Bloc blog ***************/
		$this->helper_register_block_type( 
			'blog',
			'Bloc actualités pour page Accueil',
			'Section avec titre principal, sous-titre, et les trois derniers articles publiés sur le blog.',
			'star-filled', 
			false, 
			array('blog', 'article', 'accueil','publication','actualité')
		);


		/*********Bloc carrousel de logos ***************/
		$this->helper_register_block_type( 
			'carrousel',
			'Bloc carrousel de logos de clients',
			'Section avec titre, carrousel de logos des clients et un lien.',
			'star-filled', 
			true, //besoin de JS pour le carrousel
			array('logo', 'accueil','carrousel','client')
		);


		/*********Bloc agence-vision ***************/
		$this->helper_register_block_type( 
			'agence-vision',
			'Bloc vision pour page Agence',
			'Section avec titre, texte et un encart sur une photo.',
			'star-filled', 
			false, 
			array('agence', 'vision')
		);

		/*********Bloc agence-leviers ***************/
		$this->helper_register_block_type( 
			'agence-leviers',
			'Bloc leviers pour page Agence',
			'Section sur fond gris avec titre, plusieurs leviers séparés par des traits bleus et un texte en encart sur deux photos. En version mobile, les photos sont masquées.',
			'star-filled', 
			false, 
			array('agence', 'levier','performance')
		);

		/*********Bloc agence-adn ***************/
		$this->helper_register_block_type( 
			'agence-adn',
			'Bloc ADN pour page Agence',
			'Section avec titre, intro, 4 valeurs avec picto et texte.',
			'star-filled', 
			false, 
			array('agence', 'valeur','adn')
		);

		/*********Bloc agence-equipe ***************/
		$this->helper_register_block_type( 
			'agence-equipe',
			'Bloc équipes pour page Agence',
			'Section sur fond gris avec titre, intro, photo et liste des collaborateurs (rôle et bio dans un volet escamotable). La photo est masquée en mobile',
			'star-filled', 
			true, //volet escamotable
			array('agence', 'equipe')
		);

		/*********Bloc prestations-accompagnement ***************/
		$this->helper_register_block_type( 
			'prestations-accompagnement',
			'Bloc accompagnement pour page Prestations',
			'Section avec titre et services détaillés sur 3 colonnes.',
			'star-filled', 
			true, //Uniformiser les hauteurs 
			array('prestation', 'service', 'accompagnement')
		);

		/*********Bloc prestations-expertise ***************/
		$this->helper_register_block_type( 
			'prestations-expertise',
			'Bloc expertises pour page Prestations',
			'Section avec titre, 4 expertises avec picto et texte.',
			'star-filled', 
			false, 
			array('prestation', 'expertise')
		);

		/*********Bloc prestations-programmes ***************/
		$this->helper_register_block_type( 
			'prestations-programmes',
			'Bloc programmes pour page Prestations',
			'Section avec titre, texte et un encart sur une photo.',
			'star-filled', 
			false, 
			array('prestations', 'programmes')
		);

		/*********Bloc ecosysteme-partenaires ***************/
		$this->helper_register_block_type( 
			'ecosysteme-partenaires',
			'Bloc partenaires pour page Ecosysteme',
			'Section avec titre, intro et partenaires sur 3 colonnes.',
			'star-filled', 
			false, 
			array('ecosysteme', 'partenaires')
		);
		

		/*********Bloc logos-grille ***************/
		$this->helper_register_block_type( 
			'logos-grille',
			'Bloc grille de logos pour page Ecosystème',
			'Section avec titre, intro, et grille de logos avec pagination.',
			'star-filled', 
			true, //pour pagination
			array('logo', 'référence','ecosysteme','grille')
		);

		/*********Bloc ecosysteme-mecenat ***************/
		$this->helper_register_block_type( 
			'ecosysteme-mecenat',
			'Bloc mécénat pour page Ecosystème',
			'Section avec titre, intro, texte et cta, à côté de deux photos.',
			'star-filled', 
			false, 
			array('ecosysteme', 'mecenat','mécénat')
		);
		

	}
}
new BE_ACF_Customizations();
