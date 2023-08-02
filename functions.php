<?php
/**
 * kasutan functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kasutan
 */

define( 'KASUTAN_STARTER_VERSION', filemtime( get_template_directory() . '/style.css' ) );


// General cleanup
include_once( get_template_directory() . '/inc/wordpress-cleanup.php' );

// Theme
include_once( get_template_directory() . '/inc/tha-theme-hooks.php' );
include_once( get_template_directory() . '/inc/helper-functions.php' );
include_once( get_template_directory() . '/inc/navigation.php' );
include_once( get_template_directory() . '/inc/loop.php' );
include_once( get_template_directory() . '/inc/template-tags.php' );
include_once( get_template_directory() . '/inc/site-header.php' );
include_once( get_template_directory() . '/inc/site-footer.php' );

// Editor
include_once( get_template_directory() . '/inc/disable-editor.php' );
include_once( get_template_directory() . '/inc/tinymce.php' );

// Functionality
include_once( get_template_directory() . '/inc/login-logo.php' );

// Plugin Support
include_once( get_template_directory() . '/inc/acf.php' );

if ( ! function_exists( 'kasutan_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function kasutan_setup() {
		
		// Body open hook
		add_theme_support( 'body-open' );
		
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails', array('post','page','references'));

		register_nav_menus( array(
			'primary' => 'Menu principal',
			'footer-2' => 'Menu colonne 2 du pied de page',
			'footer-3' => 'Menu colonne 3 du pied de page',
			'footer-copyright' => 'Liens légaux dans le pied de page',
		) );

		//Autoriser les shortcodes dans les widgets
		add_filter( 'widget_text', 'shortcode_unautop' );
		add_filter( 'widget_text', 'do_shortcode' );


		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			//'comment-form',
			//'comment-list',
			'gallery',
			'caption',
		) );


		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 60,
			'width'       => 340,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Gutenberg

		// -- Responsive embeds
		add_theme_support( 'responsive-embeds' );

		// -- Wide Images
		add_theme_support( 'align-wide' );

		// -- Disable custom font sizes
		add_theme_support( 'disable-custom-font-sizes' );

		/**
		* Font sizes in editor
		* https://www.billerickson.net/building-a-gutenberg-website/#editor-font-sizes
		*/
		add_theme_support( 'editor-font-sizes', array(
			array(
				'name' => __( 'Petite', 'croissancebleue' ),
				'size' => 12,
				'slug' => 'small'
			),
			array(
				'name' => __( 'Normale', 'croissancebleue' ),
				'size' => 15,
				'slug' => 'normal'
			),
			array(
				'name' => __( 'Grande', 'croissancebleue' ),
				'size' => 25,
				'slug' => 'big'
			),
			array(
				'name' => __( 'Très grande', 'croissancebleue' ),
				'size' => 35,
				'slug' => 'huge'
			)
		) );

		

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'editor-styles.css' );
	}
endif;
add_action( 'after_setup_theme', 'kasutan_setup' );



/**
 * Enqueue scripts and styles.
 */
function kasutan_scripts() {
	wp_enqueue_style( 'croissancebleue-owl-carousel', get_template_directory_uri() . '/lib/owlcarousel/owl.carousel.min.css',array(),'2.3.4');
	wp_enqueue_style( 'croissancebleue-style', get_stylesheet_uri(),array(), filemtime( get_template_directory() . '/style.css' ) );
	

	// Move jQuery to footer
	if( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
		wp_enqueue_script( 'jquery' );
	}

	wp_enqueue_script( 'croissancebleue-navigation', get_template_directory_uri() . '/js/min/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'croissancebleue-skip-link-focus-fix', get_template_directory_uri() . '/js/min/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'croissancebleue-owl-carousel',get_template_directory_uri() . '/lib/owlcarousel/owl.carousel.min.js', array('jquery'), '2.3.4', true );

	wp_enqueue_script( 'croissancebleue-scripts', get_template_directory_uri() . '/js/min/main.js', array('jquery','croissancebleue-owl-carousel'), '', true );

	//scripts pour la pagination des actus
	if(is_home() || is_category()) {
		wp_enqueue_script( 'croissancebleue-listjs', get_template_directory_uri() . '/lib/list/list.min.js', array(), '1.0', true );
		wp_enqueue_script( 'croissancebleue-pagination', get_template_directory_uri() . '/js/min/pagination.js', array('jquery','croissancebleue-listjs'), filemtime( get_template_directory() . '/js/min/pagination.js'), true );
	}
}
add_action( 'wp_enqueue_scripts', 'kasutan_scripts' );


/**
* Image sizes. 
* https://developer.wordpress.org/reference/functions/add_image_size/
*/
/*Autres tailles réglées en bo : 
• small 250 carré  ne pas forcer crop : logos clients
• medium 536 hauteur libre -> actus
• medium_large 754 * 592-> actu à la une
• large 915 * 1096 -> grande photo dans un bloc interne


*/
add_image_size('banniere_home',1230,930,false);
add_image_size('banniere',1050,930,false);
update_option( 'medium_large_size_w', 754 ); 
update_option( 'medium_large_size_h', 592);


/**
 * Afficher tous les résultats sans pagination sur page résultats de recherche et sur les archives du blog
 */
function kasutan_remove_pagination( $query ) {
	if ( $query->is_main_query() && (is_home() || is_category() || get_query_var( 's', 0 ) ) ) {
		$query->query_vars['nopaging'] = 1;
		$query->query_vars['posts_per_page'] = -1;
	}
}
add_action( 'pre_get_posts', 'kasutan_remove_pagination' );


/**
* Template Hierarchy
*
*/
function ea_template_hierarchy( $template ) {

	if( is_home() || is_search() )
		$template = get_query_template( 'archive' );
	return $template;
}
add_filter( 'template_include', 'ea_template_hierarchy' );