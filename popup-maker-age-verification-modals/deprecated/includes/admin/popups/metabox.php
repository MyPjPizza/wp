<?php


/**
 * Register all the meta boxes for the Popup custom post type
 *
 * @since 1.0
 * @return void
 */
function popmake_av_add_popup_meta_box() {
	/** Exit Popup Meta **/
	add_meta_box( 'popmake_popup_age_verification', __( 'Age Verification Modals Settings', 'popup-maker-age-verification-modals' ),  'popmake_render_popup_age_verification_meta_box', 'popup', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'popmake_av_add_popup_meta_box' );


function popmake_av_popup_meta_fields( $fields ) {
	return array_merge( $fields, array(
		'popup_age_verification_defaults_set',
	));
}
add_filter( 'popmake_popup_meta_fields', 'popmake_av_popup_meta_fields' );


function popmake_av_popup_meta_field_groups( $groups ) {
	return array_merge( $groups, array(
		'age_verification',
	));
}
add_filter( 'popmake_popup_meta_field_groups', 'popmake_av_popup_meta_field_groups' );


function popmake_av_popup_meta_field_group_age_verification( $fields ) {
	return array_merge( $fields, array(
		'enabled',
		'type',
		'required_age',
		'exiturl',
		'cookie_time',
		'cookie_path'
	));
}
add_filter('popmake_popup_meta_field_group_age_verification', 'popmake_av_popup_meta_field_group_age_verification', 0);


/** Popup Configuration *****************************************************************/

/**
 * Popup Age Verification Modals Metabox
 *
 * Extensions (as well as the core plugin) can add items to the popup display
 * configuration metabox via the `popmake_popup_age_verification_meta_box_fields` action.
 *
 * @since 1.0
 * @return void
 */
function popmake_render_popup_age_verification_meta_box() {
	global $post, $popmake_options;?>
	<input type="hidden" name="popup_age_verification_defaults_set" value="true" />
	<div id="popmake_popup_age_verification_fields" class="popmake_meta_table_wrap">
		<table class="form-table">
			<tbody>
				<?php do_action( 'popmake_popup_age_verification_meta_box_fields', $post->ID );?>
			</tbody>
		</table>
	</div><?php
}