<?php
/**
 * wpfolio functions and definitions
 *
 * @package wpfolio
 * @since wpfolio 1.1
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since wpfolio 1.1
 */
if ( ! isset( $content_width ) )
	$content_width = 980; /* pixels */

if ( ! function_exists( 'wpfolio_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since wpfolio 1.1
 */
function wpfolio_setup() {

	/**
	 * Custom menu functionality for this theme.
	 */
	require( get_template_directory() . '/inc/menus.php' );

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * WordPress.com-specific functions and definitions
	 */
	//require( get_template_directory() . '/inc/wpcom.php' );

	/**
	 * Custom Theme Options
	 */
	require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on wpfolio, use a find and replace
	 * to change 'wpfolio' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'wpfolio', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 300, 200, true ); // 300 pixels wide by 200 pixels high, hard crop mode
	add_image_size( 'wpfolio-featured-thumbnail', 300, 200, true ); // 300 pixels wide by 200 pixels high, hard crop mode

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'image', 'gallery', 'link', 'quote', 'video' ) );

	/**
	 * This theme uses wp_nav_menu() in two locations.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'wpfolio' ),
		'secondary' => __( 'Secondary Menu', 'wpfolio' ),
	) );

	/**
	 * Custom Background
	 */
	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background' );
	} else {
		add_custom_background();
	}
}
endif; // wpfolio_setup
add_action( 'after_setup_theme', 'wpfolio_setup' );

/**
 * Load wpfolio options
 */
global $wpfolio_options;
$wpfolio_options = get_option( 'wpfolio_theme_options' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since wpfolio 1.1
 */
function wpfolio_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar 1', 'wpfolio' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'wpfolio_widgets_init' );

/**
 * Enqueue scripts and styles
 *
 * @since wpfolio 1.1
 */
function wpfolio_scripts() {
	global $wpfolio_options;

	// Theme stylesheet
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'mobile', get_template_directory_uri() . '/css/mobile.css' );

	// Threaded comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Selectivizr - CSS3 pseudo-class and attribute selectors for IE 6-8
	wp_register_script( 'selectivizr', get_template_directory_uri() . '/js/selectivizr-min.js', array( 'jquery' ), '1.0.2' );
		wp_enqueue_script( 'selectivizr' );

	// Reveal: jQuery Modals Made Easy
	if ( isset( $wpfolio_options[ 'wpfolio_display_contact_information' ] ) && 'on' == $wpfolio_options[ 'wpfolio_display_contact_information' ] ) {
		wp_register_script( 'reveal', get_template_directory_uri() . '/js/jquery.reveal.js', array( 'jquery' ), '1.0' );
			wp_enqueue_script( 'reveal' );
	}

	// Tweetable: jQuery twitter feed plugin, https://github.com/philipbeel/Tweetable
	if (
		is_home() &&
		isset( $wpfolio_options[ 'wpfolio_twitter_id' ] ) && '' != $wpfolio_options[ 'wpfolio_twitter_id' ] &&
		isset( $wpfolio_options[ 'wpfolio_display_welcome_area' ] ) && 'on' == $wpfolio_options[ 'wpfolio_display_welcome_area' ]
	) {
		wp_register_script( 'twitter_widgets', get_template_directory_uri() . '/js/widgets.js', array( 'jquery' ), '2.1.1' );
			wp_enqueue_script( 'twitter_widgets' );
	}

	// FitVids.js: A lightweight, easy-to-use jQuery plugin for fluid width video embeds.
	wp_register_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.0' );
		wp_enqueue_script( 'fitvids' );

	// wpfolio custom JS
	wp_register_script( 'core', get_template_directory_uri() . '/js/jquery.core.js' );
		wp_enqueue_script( 'core' );

}
add_action( 'wp_enqueue_scripts', 'wpfolio_scripts' );

/**
 * Implement the Custom Header feature
 *
 * @since wpfolio 1.1
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Show tweets in Welcome Area if active
 */
function wpfolio_welcome_area_tweets() {
	if ( ! is_home() )
		return;

	global $wpfolio_options;
	if (
		isset( $wpfolio_options[ 'wpfolio_twitter_id' ] ) && '' != $wpfolio_options[ 'wpfolio_twitter_id' ] &&
		isset( $wpfolio_options[ 'wpfolio_display_welcome_area' ] ) && 'on' == $wpfolio_options[ 'wpfolio_display_welcome_area' ]
	) : ?>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ){
				$( '#tweets' ).tweetable({
					limit: 1,
					username: '<?php echo esc_attr( $wpfolio_options[ 'wpfolio_twitter_id' ] ); ?>',
					replies: true
				});
			});
		</script><?php
	endif;
}
add_action( 'wp_head', 'wpfolio_welcome_area_tweets' );