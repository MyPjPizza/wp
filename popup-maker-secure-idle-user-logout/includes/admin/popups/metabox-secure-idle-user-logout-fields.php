<?php
/**
 * Renders popup age verification fields
 * @since 1.0
 * @param $post_id
 */
add_action('popmake_popup_secure_logout_meta_box_fields', 'popmake_popup_secure_logout_meta_box_field_enabled', 10);
function popmake_popup_secure_logout_meta_box_field_enabled( $popup_id ) {
	?><tr>
		<th scope="row"><?php _e( 'Enable Secure Idle User Logout', 'popup-maker-secure-idle-user-logout' );?></th>
		<td>
			<input type="checkbox" value="true" name="popup_secure_logout_enabled" id="popup_secure_logout_enabled" <?php echo popmake_get_popup_secure_logout( $popup_id, 'enabled' ) ? 'checked="checked" ' : '';?>/>
			<label for="popup_secure_logout_enabled" class="description"><?php _e( 'Checking this will enable the secure logout popup to open automatically.', 'popup-maker-secure-idle-user-logout' );?></label>
		</td>
	</tr><?php
}


add_action('popmake_popup_secure_logout_meta_box_fields', 'popmake_popup_secure_logout_meta_box_field_force_logout_after', 20);
function popmake_popup_secure_logout_meta_box_field_force_logout_after( $popup_id ) {
	?><tr class="securelogout-enabled">
		<th scope="row">
			<label for="popup_secure_logout_force_logout_after"><?php _e( 'Force Logout After?', 'popup-maker-secure-idle-user-logout' );?></label> 
		</th>
		<td>
			<input type="text" readonly
				value="<?php esc_attr_e(popmake_get_popup_secure_logout( $popup_theme_id, 'force_logout_after' ))?>"
				name="popup_secure_logout_force_logout_after"
				id="popup_secure_logout_force_logout_after"
				class="popmake-range-manual"
				step="<?php esc_html_e(apply_filters('popmake_popup_step_secure_logout_force_logout_after', 1));?>"
				min="<?php esc_html_e(apply_filters('popmake_popup_min_secure_logout_force_logout_after', 1));?>"
				max="<?php esc_html_e(apply_filters('popmake_popup_max_secure_logout_force_logout_after', 60));?>"
			/>
			<span class="range-value-unit regular-text">min</span>
			<p class="description"><?php _e( 'This is the total idle time beofre a user will be warned and logged out.', 'popup-maker-secure-idle-user-logout' ); ?></p>
		</td>
	</tr><?php
}


add_action('popmake_popup_secure_logout_meta_box_fields', 'popmake_popup_secure_logout_meta_box_field_warning_timer', 20);
function popmake_popup_secure_logout_meta_box_field_warning_timer( $popup_id ) {
	?><tr class="securelogout-enabled">
		<th scope="row">
			<label for="popup_secure_logout_warning_timer"><?php _e( 'Warning Time', 'popup-maker-secure-idle-user-logout' );?></label> 
		</th>
		<td>
			<input type="text" readonly
				value="<?php esc_attr_e(popmake_get_popup_secure_logout( $popup_theme_id, 'warning_timer' ))?>"
				name="popup_secure_logout_warning_timer"
				id="popup_secure_logout_warning_timer"
				class="popmake-range-manual"
				step="<?php esc_html_e(apply_filters('popmake_popup_step_secure_logout_warning_timer', 1));?>"
				min="<?php esc_html_e(apply_filters('popmake_popup_min_secure_logout_warning_timer', 0));?>"
				max="<?php esc_html_e(apply_filters('popmake_popup_max_secure_logout_warning_timer', 60));?>"
			/>
			<span class="range-value-unit regular-text">sec</span>
			<p class="description"><?php _e( 'This is the time a user will be warned and then immediately logged out.', 'popup-maker-secure-idle-user-logout' ); ?></p>
		</td>
	</tr><?php
}