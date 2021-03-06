<?php
/**
 * Magnus functions and definitions
 *
 * @package Magnus
 * @since Magnus 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Magnus 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 700; /* pixels */

if ( ! function_exists( 'magnus_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Magnus 1.0
 */
function magnus_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	//require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	//require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Magnus, use a find and replace
	 * to change 'magnus' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'magnus', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1400 , 9999 );

	/**
	 * This theme uses wp_nav_menu() in two location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'magnus' ),
		'footer' => __( 'Footer Menu', 'magnus' ),
	) );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image' , 'quote' , 'video' , 'status' , 'link' , 'gallery', 'audio' ) );

}
endif; // magnus_setup
add_action( 'after_setup_theme', 'magnus_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Magnus 1.0
 */
function magnus_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'magnus' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'magnus_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function magnus_scripts() {
	global $post;

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'magnus_scripts' );

/**
 * Enqueue Google Fonts
 */
function magnus_load_fonts() {
	wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Arvo:400,400italic|Montserrat');
	wp_enqueue_style( 'googleFonts');
	}
add_action('wp_print_styles', 'magnus_load_fonts');

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );
