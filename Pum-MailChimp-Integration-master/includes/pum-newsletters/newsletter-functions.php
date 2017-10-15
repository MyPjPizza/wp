<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'popmake_settings_extensions', 'pum_newsletter_global_settings', 1 );

/**
 * Add settings
 *
 * @since       1.0.0
 * @param       array $settings The existing Popup Maker settings array
 * @return      array The modified Popup Maker settings array
 */
function pum_newsletter_global_settings( $settings ) {
	$new_settings = array(
			array(
					'id'    => 'newsletter_default',
					'name'  => '<strong>' . __( 'Default Mailing Service', 'pum-mailchimp-integration' ) . '</strong>',
					'desc'  => __( 'The default maling service used for the subscription form.', 'pum-mailchimp-integration' ),
					'type'  => 'select',
					'options' => apply_filters('pum_newsletter_default', array() )
			)
	);

	return array_merge( $settings, $new_settings );
}

/**
 * Load frontend styles
 *
 * @since       1.0.0
 * @return      void
 */
function pum_newsletter_scripts( $hook ) {
    // Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  wp_enqueue_style( 'pum-newsletter-styles', plugins_url( 'newsletter-styles' . $suffix . '.css' , __FILE__ ) );
	wp_enqueue_script( 'pum_newsletter_script', plugins_url( 'newsletter-scripts' . $suffix . '.js', __FILE__ ) , array( 'jquery', 'popup-maker-site' ) );
	wp_localize_script( 'pum_newsletter_script', 'pum_sub_ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'pum_newsletter_scripts' );
?>
