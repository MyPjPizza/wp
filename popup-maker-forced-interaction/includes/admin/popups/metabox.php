<?php


/**
 * Register all the meta boxes for the Popup custom post type
 *
 * @since 1.0
 * @return void
 */
function popmake_fi_add_popup_meta_box() {
	/** Scroll Pops Meta **/
	add_meta_box( 'popmake_popup_forced_interaction', __( 'Forced Interaction Settings', 'popup-maker-forced-interaction' ), 'popmake_fi_render_popup_forced_interaction_meta_box', 'popup', 'normal', 'high' );
}

add_action( 'add_meta_boxes', 'popmake_fi_add_popup_meta_box' );


add_action( 'init', 'popmake_fi_popup_fields' );
function popmake_fi_popup_fields() {
	Popmake_Popup_Fields::instance()->add_fields( 'close', array(
		'disabled' => array(
			'type'        => 'checkbox',
			'priority'    => 5,
		),
	) );
}

function popmake_fi_popup_close_meta_fields( $fields ) {
	return array_merge( $fields, array(
		'disabled',
	) );
}

add_filter( 'popmake_popup_meta_field_group_close', 'popmake_fi_popup_close_meta_fields' );


/** Popup Configuration *****************************************************************/

/**
 * Popup Forced Interaction Metabox
 *
 * Extensions (as well as the core plugin) can add items to the popup display
 * configuration metabox via the `popmake_popup_forced_interaction_meta_box_fields` action.
 *
 * @since 1.0
 * @return void
 */
function popmake_fi_render_popup_forced_interaction_meta_box() {
	global $post, $popmake_options; ?>
	<input type="hidden" name="popup_forced_interaction_defaults_set" value="true" />
	<div id="popmake_popup_forced_interaction_fields" class="popmake_meta_table_wrap">
	<table class="form-table">
		<tbody>
		<?php do_action( 'popmake_popup_forced_interaction_meta_box_fields', $post->ID ); ?>
		</tbody>
	</table>
	</div><?php
}