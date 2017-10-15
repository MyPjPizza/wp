<?php


/**
 * Register all the meta boxes for the Popup custom post type
 *
 * @since 1.0
 * @return void
 */
function popmake_siul_add_popup_meta_box() {
	/** Exit Popup Meta **/
	add_meta_box( 'popmake_popup_secure_logout', __( 'Secure Idle User Logout Settings', 'popup-maker-secure-idle-user-logout' ),  'popmake_render_popup_secure_logout_meta_box', 'popup', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'popmake_siul_add_popup_meta_box' );


function popmake_siul_popup_meta_fields( $fields ) {
	return array_merge( $fields, array(
		'popup_secure_logout_defaults_set',
	));
}
add_filter( 'popmake_popup_meta_fields', 'popmake_siul_popup_meta_fields' );


function popmake_siul_popup_meta_field_groups( $groups ) {
	return array_merge( $groups, array(
		'secure_logout',
	));
}
add_filter( 'popmake_popup_meta_field_groups', 'popmake_siul_popup_meta_field_groups' );


function popmake_siul_popup_meta_field_group_secure_logout( $fields ) {
	return array_merge( $fields, array(
		'enabled',
		'force_logout_after',
		'warning_timer',
	));
}
add_filter('popmake_popup_meta_field_group_secure_logout', 'popmake_siul_popup_meta_field_group_secure_logout', 0);


/** Popup Configuration *****************************************************************/

/**
 * Popup Secure Idle User Logout Metabox
 *
 * Extensions (as well as the core plugin) can add items to the popup display
 * configuration metabox via the `popmake_popup_secure_logout_meta_box_fields` action.
 *
 * @since 1.0
 * @return void
 */
function popmake_render_popup_secure_logout_meta_box() {
	global $post, $popmake_options;?>
	<input type="hidden" name="popup_secure_logout_defaults_set" value="true" />
	<div id="popmake_popup_secure_logout_fields" class="popmake_meta_table_wrap">
		<table class="form-table">
			<tbody>
				<?php do_action( 'popmake_popup_secure_logout_meta_box_fields', $post->ID );?>
			</tbody>
		</table>
	</div><?php
}