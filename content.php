<?php
/**
 * @package wpfolio
 * @since wpfolio 1.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( ! is_singular() ) { ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpfolio' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
					<?php the_title(); ?>
				</a>
			</h1><!-- .entry-title -->
		<?php } else { ?>
			<h1 class="entry-title">
				<?php the_title(); ?>
			</h1><!-- .entry-title -->
		<?php } ?>

		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php wpfolio_posted_on(); ?>
				<?php wpfolio_posted_by(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->


	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content">

			<!-- Show Quote Attribution for Quote Post Format -->
			<?php if ( get_post_meta($post->ID, '_format_link_url', true) ) { ?>
				<h5><a href="<?php echo get_post_meta($post->ID, '_format_link_url', true); ?>" class="extlink"><?php echo get_post_meta($post->ID, '_format_link_url', true); ?></a></h5>
			<?php } ?>

			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wpfolio' ) ); ?>

			<!-- Show Quote Attribution for Quote Post Format -->
			<?php if ( get_post_meta($post->ID, '_format_quote_source_url', true) || get_post_meta($post->ID, '_format_quote_source_name', true) ) { ?>
			<p class="right">
				<?php if ( get_post_meta($post->ID, '_format_quote_source_url', true) ) { ?>
				<span class="entry-meta">Source:</span>
					<a href="<?php echo get_post_meta($post->ID, '_format_quote_source_url', true); ?>" rel="external">
				<?php } ?>
				<?php if ( get_post_meta($post->ID, '_format_quote_source_name', true) ) { ?>
					<?php echo get_post_meta($post->ID, '_format_quote_source_name', true); ?>
				<?php } else { ?>
					<?php echo get_post_meta($post->ID, '_format_quote_source_url', true); ?>
				<?php } ?>
				<?php if ( get_post_meta($post->ID, '_format_quote_source_url', true) ) { ?>
					</a>
				<?php } ?>
			</p>
			<?php } ?>

			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wpfolio' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'wpfolio' ) );
				if ( $categories_list && wpfolio_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'wpfolio' ), $categories_list ); ?>
			</span>
			<span class="sep"> | </span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'wpfolio' ) );
				if ( $tags_list ) :
			?>
			<span class="tag-links">
				<?php printf( __( 'Tagged %1$s', 'wpfolio' ), $tags_list ); ?>
			</span>
			<span class="sep"> | </span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type(); ?>

		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'wpfolio' ), __( '1 Comment', 'wpfolio' ), __( '% Comments', 'wpfolio' ) ); ?></span>
			<span class="sep"> | </span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'wpfolio' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->