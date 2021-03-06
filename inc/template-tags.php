<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package wpfolio
 * @since wpfolio 1.1
 */
 
if ( ! function_exists( 'wpfolio_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since wpfolio 1.1
 */
function wpfolio_content_nav( $nav_id ) {
	global $wp_query;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'wpfolio' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php if ( get_previous_post() ) { ?>
			<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'wpfolio' ) . '</span> %title' ); ?>
		<?php } else { ?>
			<div class="nav-previous">
				&nbsp;
			</div>
		<?php } ?>
		
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'wpfolio' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) { ?>
			<div class="nav-previous">
				<?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'wpfolio' ) ); ?>
			</div>
		<?php } else { ?>
			<div class="nav-previous">
				&nbsp;
			</div>
		<?php } ?>

		<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next">
				<?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'wpfolio' ) ); ?>
			</div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // wpfolio_content_nav

if ( ! function_exists( 'wpfolio_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since wpfolio 1.1
 */
function wpfolio_comment( $comment, $args, $depth ) {
	$GLOBALS[ 'comment' ] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'wpfolio' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'wpfolio' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'wpfolio' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'wpfolio' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'wpfolio' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'wpfolio' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for wpfolio_comment()

if ( ! function_exists( 'wpfolio_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 *
 * @since wpfolio 1.1
 */
function wpfolio_posted_on() {
	if ( is_multi_author() && ! is_author() ) {
		printf( __( '<a class="posted-on"href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'wpfolio' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
	} else {
		printf( __( '<a class="posted-on single-author-blog"href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>Posted on %4$s</time></a>', 'wpfolio' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
	}
}
endif;

if ( ! function_exists( 'wpfolio_posted_by' ) ) :
/**
 * Prints HTML with meta information for the entry author.
 *
 * @since wpfolio 1.1
 */
function wpfolio_posted_by() {
	if ( is_multi_author() && ! is_author() ) {
		printf( __( '<a class="author url fn n" href="%1$s" title="%2$s" rel="author">By %3$s</a>', 'wpfolio' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'wpfolio' ), get_the_author_meta( 'display_name' ) ) ),
			esc_attr( get_the_author_meta( 'display_name' ) )
		);
	}
}
endif;

if ( ! function_exists( 'wpfolio_categorized_blog' ) ) :
/**
 * Returns true if a blog has more than 1 category
 *
 * @since wpfolio 1.1
 */
function wpfolio_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so wpfolio_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so wpfolio_categorized_blog should return false
		return false;
	}
}
endif;

if ( ! function_exists( 'wpfolio_category_transient_flusher' ) ) :
/**
 * Flush out the transients used in wpfolio_categorized_blog
 *
 * @since wpfolio 1.1
 */
function wpfolio_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
endif;

add_action( 'edit_category', 'wpfolio_category_transient_flusher' );
add_action( 'save_post', 'wpfolio_category_transient_flusher' );