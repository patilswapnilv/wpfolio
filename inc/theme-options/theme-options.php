<?php
/**
 * wpfolio Theme Options
 *
 * @package wpfolio
 * @since wpfolio 1.1
 */
 
 /**
 * Properly enqueue styles and scripts for our theme options page.
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 *
 * @since wpfolio 1.1
 */
function wpfolio_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style( 'wpfolio-theme-options', get_template_directory_uri() . '/inc/theme-options/theme-options.css', false, '2012-06-13' );
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'wpfolio_admin_enqueue_scripts' );

/**
 * Register the form setting for our wpfolio_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, wpfolio_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are properly
 * formatted, and safe.
 *
 * @since wpfolio 1.1
 */
function wpfolio_theme_options_init() {
	register_setting(
		'wpfolio_options', // Options group, see settings_fields() call in wpfolio_theme_options_render_page()
		'wpfolio_theme_options', // Database option, see wpfolio_get_theme_options()
		'wpfolio_theme_options_validate' // The sanitization callback, see wpfolio_theme_options_validate()
	);
	
	add_settings_section( // Register our settings field group
		'wpfolio_welcome_area', // Unique identifier for the settings section
		'', // Section title
		'__return_false',  // Section callback (we don't want anything)
		'theme_options'  // Menu slug, used to uniquely identify the page; see wpfolio_theme_options_add_page()
	);
	
	// Welcome Area Information
	add_settings_field( // Register our individual settings fields
		'wpfolio_display_welcome_area', // Unique identifier for the field for this section
		__( 'Display Welcome Area', 'wpfolio' ), // Setting field label
		'wpfolio_display_welcome_area', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see wpfolio_theme_options_add_page()
		'wpfolio_welcome_area' // Settings section. Same as the first argument in the add_settings_section() above
	);
	add_settings_field( 'wpfolio_welcome_area_title', __( 'Welcome Area Title', 'wpfolio' ), 'wpfolio_welcome_area_title', 'theme_options', 'wpfolio_welcome_area' );
	add_settings_field( 'wpfolio_welcome_area_message', __( 'Welcome Area Message', 'wpfolio' ), 'wpfolio_welcome_area_message', 'theme_options', 'wpfolio_welcome_area' );
	add_settings_field( 'wpfolio_twitter_id', __( 'Twitter ID', 'wpfolio' ), 'wpfolio_twitter_id', 'theme_options', 'wpfolio_welcome_area' );
	add_settings_field( 'wpfolio_display_contact_information', __( 'Display Contact Information', 'wpfolio' ), 'wpfolio_display_contact_information', 'theme_options', 'wpfolio_welcome_area' );
	add_settings_field( 'wpfolio_contact_details', __( 'Contact Details', 'wpfolio' ), 'wpfolio_contact_details', 'theme_options', 'wpfolio_welcome_area' );
	add_settings_field( 'wpfolio_contact_email_address', __( 'Contact Email Address', 'wpfolio' ), 'wpfolio_contact_email_address', 'theme_options', 'wpfolio_welcome_area' );
		
}
add_action( 'admin_init', 'wpfolio_theme_options_init' );

/**
 * Change the capability required to save the 'wpfolio_options' options group.
 *
 * @see wpfolio_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see wpfolio_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function wpfolio_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_wpfolio_options', 'wpfolio_option_page_capability' );

/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since wpfolio 1.1
 */
function wpfolio_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'wpfolio' ),   // Name of page
		__( 'Theme Options', 'wpfolio' ),   // Label in menu
		'edit_theme_options',          // Capability required
		'theme_options',               // Menu slug, used to uniquely identify the page
		'wpfolio_theme_options_render_page' // Function that renders the options page
	);
}
add_action( 'admin_menu', 'wpfolio_theme_options_add_page' );

/**
 * Returns the options array for wpfolio.
 *
 * @since wpfolio 1.1
 */
function wpfolio_get_theme_options() {
	$saved = (array) get_option( 'wpfolio_theme_options' );
	$defaults = array(
		'wpfolio_display_welcome_area'			=> 'off',
		'wpfolio_welcome_area_title'			=> '',
		'wpfolio_welcome_area_message'			=> '',
		'wpfolio_twitter_id'					=> '',
		'wpfolio_display_contact_information'  => 'off',
		'wpfolio_contact_details'				=> '',
		'wpfolio_contact_email_address'		=> '',
	);

	$defaults = apply_filters( 'wpfolio_default_theme_options', $defaults );

	$options = wp_parse_args( $saved, $defaults );
	$options = array_intersect_key( $options, $defaults );

	return $options;
}

/**
 * Renders the Display Welcome Area setting field.
 */
function wpfolio_display_welcome_area() {
	$options = wpfolio_get_theme_options();
	?>
	<input type="checkbox" name="wpfolio_theme_options[wpfolio_display_welcome_area]" id="display-welcome-area" <?php checked( 'on', $options[ 'wpfolio_display_welcome_area' ] ); ?> />
	<label class="description" for="display-welcome-area"><?php _e( 'Display a welcome message at the top of your home page.', 'wpfolio' ); ?></label>
	<?php
}

/**
 * Renders the Welcome Area Title setting field.
 */
function wpfolio_welcome_area_title() {
	$options = wpfolio_get_theme_options();
	?>
	<input type="text" name="wpfolio_theme_options[wpfolio_welcome_area_title]" id="welcome-area-title" value="<?php echo esc_attr( $options[ 'wpfolio_welcome_area_title' ] ); ?>" />
	<label class="description" for="welcome-area-title"><?php _e( 'Something short and snazzy, like &#8220;Howdy!&#8221;', 'wpfolio' ); ?></label>
	<?php
}

/**
 * Renders the Welcome Area Messagesetting field.
 */
function wpfolio_welcome_area_message() {
	$options = wpfolio_get_theme_options();
	?>
	<textarea class="large-text" type="text" name="wpfolio_theme_options[wpfolio_welcome_area_message]" id="welcome-area-message" cols="50" rows="10" /><?php echo esc_textarea( $options['wpfolio_welcome_area_message'] ); ?></textarea>
	<label class="description" for="welcome-area-message"><?php _e( 'This message will appear above the thumbnails on your home page.', 'wpfolio' ); ?></label>
	<?php
}

/**
 * Renders the Twitter ID setting field.
 */
function wpfolio_twitter_id() {
	$options = wpfolio_get_theme_options();
	?>
	<input type="text" name="wpfolio_theme_options[wpfolio_twitter_id]" id="twitter-id" value="<?php echo esc_attr( $options[ 'wpfolio_twitter_id' ] ); ?>" />
	<label class="description" for="twitter-id"><?php _e( 'Tweets will be shown alongside your welcome message.', 'wpfolio' ); ?></label>
	<?php
}

/**
 * Renders the Display Contact Information setting field.
 */
function wpfolio_display_contact_information() {
	$options = wpfolio_get_theme_options(); ?>
		<input type="checkbox" name="wpfolio_theme_options[wpfolio_display_contact_information]" id="display-contact-information" <?php checked( 'on', $options[ 'wpfolio_display_contact_information' ] ); ?> />
		<label class="description" for="display-contact-information"><?php _e( 'Display contact information alongside your welcome message.', 'wpfolio' ); ?></label>
	<?php
}

/**
 * Renders the Contact Details setting field.
 */
function wpfolio_contact_details() {
	$options = wpfolio_get_theme_options();
	?>
	<textarea class="large-text" type="text" name="wpfolio_theme_options[wpfolio_contact_details]" id="contact-details" cols="50" rows="10" /><?php echo esc_textarea( $options['wpfolio_contact_details'] ); ?></textarea>
	<?php
}

/**
 * Renders the Contact Email Address setting field.
 */
function wpfolio_contact_email_address() {
	$options = wpfolio_get_theme_options();
	?>
	<input type="text" name="wpfolio_theme_options[wpfolio_contact_email_address]" id="contact-email-address" value="<?php echo esc_attr( $options[ 'wpfolio_contact_email_address' ] ); ?>" />
	<?php
}

/**
 * Renders the Theme Options administration screen.
 *
 * @since wpfolio 1.1
 */
function wpfolio_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<?php $theme_name = function_exists( 'wp_get_theme' ) ? wp_get_theme() : get_current_theme(); ?>
		<h2>
			<?php printf( __( '%s Theme Options', 'wpfolio' ), $theme_name ); ?>
		</h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'wpfolio_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see wpfolio_theme_options_init()
 * @todo set up Reset Options action
 *
 * @param array $input Unknown values.
 * @return array Sanitized theme options ready to be stored in the database.
 *
 * @since wpfolio 1.1
 */
function wpfolio_theme_options_validate( $input ) {
	$output = array();

	// Display Welcome Area?
	if ( isset( $input[ 'wpfolio_display_welcome_area' ] ) )
		$output[ 'wpfolio_display_welcome_area' ] = 'on';
		
	// Welcome Area Title
	if ( isset( $input[ 'wpfolio_welcome_area_title' ] ) && ! empty( $input[ 'wpfolio_welcome_area_title' ] ) )
		$output[ 'wpfolio_welcome_area_title' ] = strip_tags( $input[ 'wpfolio_welcome_area_title' ] );
		
	// Welcome Area Message
	if ( isset( $input[ 'wpfolio_welcome_area_message' ] ) && ! empty( $input[ 'wpfolio_welcome_area_message' ] ) )
		$output[ 'wpfolio_welcome_area_message' ] = stripslashes( wp_filter_post_kses( addslashes( $input[ 'wpfolio_welcome_area_message' ] ) ) );
		
	// Twitter ID
	if ( isset( $input[ 'wpfolio_twitter_id' ] ) && ! empty( $input[ 'wpfolio_twitter_id' ] ) && preg_match( '/^[A-Za-z0-9_]+$/', $input[ 'wpfolio_twitter_id' ] ) )
		$output[ 'wpfolio_twitter_id' ] = wp_filter_nohtml_kses( $input[ 'wpfolio_twitter_id' ] );
		
	// Display Contact Information?
	if ( isset( $input[ 'wpfolio_display_contact_information' ] ) )
		$output[ 'wpfolio_display_contact_information' ] = 'on';

	// Contact Details
	if ( isset( $input[ 'wpfolio_contact_details' ] ) && ! empty( $input[ 'wpfolio_contact_details' ] ) )
		$output[ 'wpfolio_contact_details' ] = stripslashes( wp_filter_post_kses( addslashes( $input[ 'wpfolio_contact_details' ] ) ) );
		
	// Contact Email Address
	if ( isset( $input[ 'wpfolio_contact_email_address' ] ) && ! empty( $input[ 'wpfolio_contact_email_address' ] ) && is_email( $input[ 'wpfolio_contact_email_address' ] ) )
		$output[ 'wpfolio_contact_email_address' ] = stripslashes( wp_filter_nohtml_kses( addslashes( $input[ 'wpfolio_contact_email_address' ] ) ) );

	return apply_filters( 'wpfolio_theme_options_validate', $output, $input );
	
}