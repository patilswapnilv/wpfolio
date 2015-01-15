<?php
/**
 * Custom functions that add menu functionality into the theme
 *
 * @package wpfolio
 * @since wpfolio 1.1
 */

/**
 * The secondary navigation menu in wpfolio will use
 * a custom menu, and if that's not available a fallback
 * which lists all of the populated categories on the blog.
 *
 * @since wpfolio 1.1
 */
function wpfolio_secondary_nav_menu( $output = '' ) {
	if ( ! has_nav_menu( 'secondary' ) )
		return;
		
	$output .= '<ul id="filter" class="breadcrumb"><li class="title">' . __( 'Recent Work:', 'wpfolio' ) . '</li><!-- .title -->';
	$secondary_nav_menu_args = array(
		'container' => '',
		'depth' => 1,
		'echo' => false,
		'items_wrap' => '%3$s',
		'menu_class' => 'secondary-menu',
		'theme_location' => 'secondary',
	);
	$output .= wp_nav_menu( $secondary_nav_menu_args );
	$output .= '</ul><!-- #filter -->';
	
	return $output;
}