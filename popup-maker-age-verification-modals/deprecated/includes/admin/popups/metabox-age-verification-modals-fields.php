<?php
/**
 * Renders popup age verification fields
 * @since 1.0
 * @param $post_id
 */
add_action('popmake_popup_age_verification_meta_box_fields', 'popmake_popup_age_verification_meta_box_field_enabled', 10);
function popmake_popup_age_verification_meta_box_field_enabled( $popup_id )
{
	?><tr>
		<th scope="row"><?php _e( 'Enable Age Verification Modals', 'popup-maker-age-verification-modals' );?></th>
		<td>
			<input type="checkbox" value="true" name="popup_age_verification_enabled" id="popup_age_verification_enabled" <?php echo popmake_get_popup_age_verification( $popup_id, 'enabled' ) ? 'checked="checked" ' : '';?>/>
			<label for="popup_age_verification_enabled" class="description"><?php _e( 'Checking this will cause age verification popup to open automatically.', 'popup-maker-age-verification-modals' );?></label>
		</td>
	</tr><?php
}



add_action('popmake_popup_age_verification_meta_box_fields', 'popmake_popup_age_verification_meta_box_field_type', 20);
function popmake_popup_age_verification_meta_box_field_type( $popup_id )
{
	?><tr class="ageverification-enabled">
		<th scope="row"><label for="popup_age_verification_type"><?php _e( 'Type', 'popup-maker-age-verification-modals' );?></label></th>
		<td>
			<select name="popup_age_verification_type" id="popup_age_verification_type">
			<?php foreach(apply_filters('popmake_av_age_verification_type_options', array()) as $option => $value) : ?>
				<option
					value="<?php echo $value;?>"
					<?php echo $value == popmake_get_popup_age_verification( $popup_id, 'type') ? ' selected="selected"' : '';?>
				><?php echo $option;?></option>
			<?php endforeach ?>
			</select>
			<label class="description"><?php _e( 'Choose what type of age verification to use.', 'popup-maker-age-verification-modals' );?></label>
		</td>
	</tr><?php
}


add_action('popmake_popup_age_verification_meta_box_fields', 'popmake_popup_age_verification_meta_box_field_required_age', 30);
function popmake_popup_age_verification_meta_box_field_required_age( $popup_id )
{
	?><tr class="ageverification-enabled birthdate-only">
		<th scope="row">
			<label for="popup_age_verification_required_age">
				<?php _e( 'Required Age', 'popup-maker-age-verification-modals' );?>
			</label>
		</th>
		<td>
			<input type="text" class="regular-text" name="popup_age_verification_required_age" id="popup_age_verification_required_age" value="<?php esc_attr_e(popmake_get_popup_age_verification( $popup_id, 'required_age' ))?>"/>
			<p class="description"><?php _e( 'What is the required age?', 'popup-maker-age-verification-modals' )?></p>
		</td>
	</tr><?php
}


add_action('popmake_popup_age_verification_meta_box_fields', 'popmake_popup_age_verification_meta_box_field_exiturl', 40);
function popmake_popup_age_verification_meta_box_field_exiturl( $popup_id )
{
	?><tr class="ageverification-enabled">
		<th scope="row">
			<label for="popup_age_verification_exiturl">
				<?php _e( 'Exit URL', 'popup-maker-age-verification-modals' );?>
			</label>
		</th>
		<td>
			<input type="text" class="regular-text" name="popup_age_verification_exiturl" id="popup_age_verification_exiturl" value="<?php esc_attr_e(popmake_get_popup_age_verification( $popup_id, 'exiturl' ))?>"/>
			<p class="description"><?php _e( 'Enter a url to send the user to if they fail age verification.', 'popup-maker-age-verification-modals' )?></p>
		</td>
	</tr><?php
}


add_action('popmake_popup_age_verification_meta_box_fields', 'popmake_popup_age_verification_meta_box_field_cookie_time', 50);
function popmake_popup_age_verification_meta_box_field_cookie_time( $popup_id )
{
	?><tr class="ageverification-enabled">
		<th scope="row">
			<label for="popup_age_verification_cookie_time">
				<?php _e( 'Cookie Time', 'popup-maker-age-verification-modals' );?>
			</label>
		</th>
		<td>
			<input type="text" class="regular-text" name="popup_age_verification_cookie_time" id="popup_age_verification_cookie_time" value="<?php esc_attr_e(popmake_get_popup_age_verification( $popup_id, 'cookie_time' ))?>"/>
			<p class="description"><?php _e( 'Enter a plain english time before cookie expires. <br/>Example "364 days 23 hours 59 minutes 59 seconds" will reset just before 1 year exactly.', 'popup-maker-age-verification-modals' )?></p>
		</td>
	</tr><?php
}


add_action('popmake_popup_age_verification_meta_box_fields', 'popmake_popup_age_verification_meta_box_field_cookie_path', 60);
function popmake_popup_age_verification_meta_box_field_cookie_path( $popup_id )
{
	?><tr class="ageverification-enabled">
		<th scope="row"><?php _e( 'Sitewide Cookie', 'popup-maker-age-verification-modals' );?></th>
		<td>
			<input type="checkbox" value="/" name="popup_age_verification_cookie_path" id="popup_age_verification_cookie_path" <?php echo popmake_get_popup_age_verification( $popup_id, 'cookie_path' ) ? 'checked="checked" ' : '';?>/>
			<label for="popup_age_verification_cookie_path" class="description"><?php _e( 'This will prevent the popup from opening on any page until the cookie expires.', 'popup-maker-age-verification-modals' );?></label>
		</td>
	</tr><?php
}





















