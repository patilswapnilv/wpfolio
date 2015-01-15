<?php
/**
 * The template for displaying posts in the Gallery Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package wpfolio
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title">
			<?php the_title(); ?>
		</h1><!-- .entry-title -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<dl class="tabs">
			<dd>
				<a class="active" href="#simple1"><?php _e( 'Gallery', 'wpfolio' ); ?></a>
			</dd>
			<dd>
				<a href="#simple2"><?php _e( 'Info', 'wpfolio' ); ?></a>
			</dd>
			<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
				<dd>
					<a href="#simple3">
						<?php comments_number( __( 'Comments', 'wpfolio' ), __( '1 Comment', 'wpfolio' ), __( '% Comments', 'wpfolio' ) ); ?>
					</a>
				</dd>
			<?php endif; ?>
		</dl><!-- .tabs -->
		<ul class="tabs-content">
			<li id="simple1tab" class="active">
				<?php echo do_shortcode( '[gallery columns="3"]' ); ?>
			</li><!-- #simple1tab -->
			<li id="simple2tab">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wpfolio' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wpfolio' ), 'after' => '</div>' ) ); ?>
				<footer class="entry-meta">
					<?php wpfolio_posted_on(); wpfolio_posted_by(); ?>
					<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
						<span class="sep"><?php _e( ' | ', 'wpfolio' ); ?></span>
						<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'wpfolio' ), __( '1 Comment', 'wpfolio' ), __( '% Comments', 'wpfolio' ) ); ?></span>
					<?php endif; ?>
					<?php edit_post_link( __( 'Edit', 'wpfolio' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
				</footer><!-- #entry-meta -->
			</li><!-- #simple2tab -->
			<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
				<li id="simple3tab">
					<?php comments_template( '', true ); ?>
				</li><!-- #simple3tab -->
			<?php endif; ?>
		</ul><!-- .tabs-content -->
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->