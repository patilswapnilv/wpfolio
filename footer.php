<?php global $wpfolio_options;
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package wpfolio
 */
?>
				</div><!-- .twelve -->
			</div><!-- #main -->
		</div><!-- .main-outer -->

		<footer id="colophon" class="row" role="contentinfo">
			<div id="site-generator" class="twelve columns">
				<?php printf( __( 'Proudly powered by %1$s', 'wpfolio' ), '<a href="http://wordpress.org/" rel="generator">WordPress</a>' ); ?>
				<span class="right">
					<?php printf( __( 'Theme: %1$s by %2$s', 'wpfolio' ), '<a href="http://codepixels.net/themes/wpfolio/">wpfolio</a>', '<a href="http://codepixels.net/" rel="designer">Code Pixels</a>' ); ?>
				</span><!-- .right -->
			</div><!-- #site-generator -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php if ( isset( $wpfolio_options[ 'wpfolio_display_contact_information' ] ) && 'on' == $wpfolio_options[ 'wpfolio_display_contact_information' ] ) : ?>
		<div id="contact" class="reveal-modal">
			<h2>
				<?php _e( 'Contact', 'wpfolio' ); ?>
			</h2>
			<?php if ( isset( $wpfolio_options[ 'wpfolio_contact_details' ] ) && '' != $wpfolio_options[ 'wpfolio_contact_details' ] ) : ?>
				<div class="lead">
					<?php echo $wpfolio_options[ 'wpfolio_contact_details' ]; // HTML Allowed ?>
				</div><!-- .lead -->
			<?php endif; ?>
			<?php if ( isset( $wpfolio_options[ 'wpfolio_contact_email_address' ] ) && '' != $wpfolio_options[ 'wpfolio_contact_email_address' ] ) : ?>
				<div class="lead">
					<a href="mailto:<?php echo antispambot( sanitize_email( $wpfolio_options[ 'wpfolio_contact_email_address' ] ) ); ?>"><?php echo antispambot( sanitize_email( $wpfolio_options[ 'wpfolio_contact_email_address' ] ) ); ?></a>
				</div><!-- .lead -->
			<?php endif; ?>
			<a class="close-reveal-modal">&#215;</a>
		</div><!-- .contact -->
	<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>