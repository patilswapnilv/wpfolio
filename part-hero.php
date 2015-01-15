<?php
	global $wpfolio_options;
	if ( isset( $wpfolio_options[ 'wpfolio_display_welcome_area' ] ) ) :
?>

	<div class="row">
		<div class="hero clearfix">
			<?php if ( ! isset( $wpfolio_options[ 'wpfolio_display_contact_information' ] ) && ! isset( $wpfolio_options[ 'wpfolio_twitter_id' ] ) ) { ?>
				<div class="columns twelve">
			<?php } else { ?>
				<div class="columns eight">
			<?php } ?>
				<?php if ( isset( $wpfolio_options[ 'wpfolio_welcome_area_title' ] ) ) : ?>
					<h2>
						<?php echo esc_html( $wpfolio_options[ 'wpfolio_welcome_area_title' ] ); ?>
					</h2>
				<?php endif; ?>
				<?php if ( isset( $wpfolio_options[ 'wpfolio_welcome_area_message' ] ) ) : ?>
					<div class="subheader">
						<?php echo $wpfolio_options[ 'wpfolio_welcome_area_message' ]; // HTML Allowed ?>
					</div>
				<?php endif; ?>
			</div><!-- .eight -->

			<?php if ( isset( $wpfolio_options[ 'wpfolio_display_contact_information' ] ) || isset( $wpfolio_options[ 'wpfolio_twitter_id' ] ) ) : ?>
				<div class="columns four">
					<?php if ( isset( $wpfolio_options[ 'wpfolio_twitter_id' ] ) ) : ?>
						<h3 class="twitter">
							<a href="<?php echo esc_attr( 'http://twitter.com/' . $wpfolio_options[ 'wpfolio_twitter_id' ] ); ?>" title="<?php esc_attr_e( 'Follow me on Twitter', 'wpfolio' ); ?>">
								<?php _e( 'Follow', 'wpfolio' ); ?>
							</a>
						</h3>
						<a class="twitter-timeline" href="https://twitter.com/twitterapi" data-widget-id="487225123984785408" data-tweet-limit="1" data-chrome="noheader nofooter noborders noscrollbar transparent" data-screen-name="<?php echo $wpfolio_options[ 'wpfolio_twitter_id' ]; ?>"></a>
						<hr />
					<?php endif; ?>
					<?php if ( isset( $wpfolio_options[ 'wpfolio_display_contact_information' ] ) ) : ?>
						<a href="#" class="button charcoal radius large full-width" data-reveal-id="contact"><?php _e( 'Contact', 'wpfolio' ); ?></a>
					<?php endif; ?>
				</div><!-- .four -->
			<?php endif; ?>
		</div><!-- .hero -->
	</div><!-- .row -->
<?php endif; ?>