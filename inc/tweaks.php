<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package wpfolio
 * @since wpfolio 1.1
 */

if ( ! function_exists( 'wpfolio_page_menu_args' ) ) :
/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since wpfolio 1.1
 */
function wpfolio_page_menu_args( $args ) {

	if( 'primary' === $args[ 'theme_location' ] )
		$args[ 'show_home' ] = true;
	
	return $args;
}
endif;

add_filter( 'wp_page_menu_args', 'wpfolio_page_menu_args' );

if ( ! function_exists( 'wpfolio_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 *
 * @since wpfolio 1.1
 */
function wpfolio_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author and class of single-author to blogs with only 1 published author
	if ( is_multi_author() )
		$classes[] = 'group-blog';
	else
		$classes[] = 'single-author';

	return $classes;
}
endif;

add_filter( 'body_class', 'wpfolio_body_classes' );

if ( ! function_exists( 'wpfolio_widget_tag_cloud_args' ) ) :
/**
 * Modify the font sizes of WordPress' tag cloud
 *
 * @since wpfolio 1.1
 */
function wpfolio_widget_tag_cloud_args( $args ) {
	$args[ 'smallest' ] = 13;
	$args[ 'largest' ]= 21;
	$args[ 'unit' ]= 'px';
	return $args;
}
endif;

add_filter( 'widget_tag_cloud_args', 'wpfolio_widget_tag_cloud_args' );

if ( ! function_exists( 'wpfolio_excerpt_length' ) ) :
/**
 * Modify the default excerpt length
 *
 * @since wpfolio 1.1
 */
function wpfolio_excerpt_length( $length ) {
	return 35;
}
endif;

add_filter( 'excerpt_length', 'wpfolio_excerpt_length' );

if ( ! function_exists( 'wpfolio_post_thumbnail_html' ) ) :
/**
 * Remove the height and width attributes from post thumbnails to allow for responsive design.
 *
 * @since wpfolio 1.1
 */
function wpfolio_post_thumbnail_html( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
endif;

add_filter( 'post_thumbnail_html', 'wpfolio_post_thumbnail_html', 10, 3 );

if ( ! function_exists( 'wpfolio_the_category' ) ) :
/**
 * HTML5 rel attribute validation fix
 *
 * @since wpfolio 1.1
 */
function wpfolio_the_category( $text ) {
	$text = str_replace( 'rel="category"', 'rel="tag"', $text); return $text;
}
endif;

add_filter( 'the_category', 'wpfolio_the_category' );

if ( ! function_exists( 'wpfolio_enhanced_image_navigation' ) ) :
/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since wpfolio 1.1
 */
function wpfolio_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#image-attachment-anchor';

	return $url;
}
endif;

add_filter( 'attachment_link', 'wpfolio_enhanced_image_navigation', 10, 2 );