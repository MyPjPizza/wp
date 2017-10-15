<?php
/**
 * Renders popup close fields
 * @since 1.0
 * @param $post_id
 */

add_action('popmake_popup_forced_interaction_meta_box_fields', 'popmake_popup_forced_interaction_meta_box_field_disabled', 5);
function popmake_popup_forced_interaction_meta_box_field_disabled( $popup_id ) {
	?><tr>
		<th scope="row"><?php _e('Disable Close', 'popup-maker-forced-interaction' );?></th>
		<td><?php
			$value = pum_popup( $popup_id )->get_close( 'disabled' );

			if ( $value == 'true' ) {
					$value = 1;
			} ?>
			<input type="checkbox" value="1" name="popup_close_disabled" id="popup_close_disabled" <?php checked( 1, $value ); ?> />
			<label for="popup_close_disabled" class="description"><?php _e('Checking this will disable and hide the close button for this popup.', 'popup-maker-forced-interaction' );?></label>
		</td>
	</tr><?php
}