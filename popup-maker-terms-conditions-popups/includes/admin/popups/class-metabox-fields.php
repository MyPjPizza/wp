<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PopMake_Terms_Conditions_Popups_Admin_Popup_Metabox_Fields' ) ) {

	/**
	 * Main PopMake_Terms_Conditions_Popups_Admin_Popup_Metabox_Fields class
	 *
	 * @since       1.0.0
	 */
	class PopMake_Terms_Conditions_Popups_Admin_Popup_Metabox_Fields {

		public function enabled( $popup_id ) { ?>
			<tr>
				<th scope="row"><?php _e( 'Enable T&C Popup', 'popup-maker-terms-conditions-popups' );?></th>
				<td>
					<input type="checkbox" value="true" name="popup_terms_conditions_enabled" id="popup_terms_conditions_enabled" <?php checked( popmake_get_popup_terms_conditions( $popup_id, 'enabled' ), 'true' );?>/>
					<label for="popup_terms_conditions_enabled" class="description"><?php _e( 'Checking this creates a terms & conditions popup.', 'popup-maker-terms-conditions-popups' );?></label>
				</td>
			</tr><?php
		}

		public function checkbox_style( $popup_id ) { ?>
			<tr class="terms-conditions-enabled">
				<th scope="row"><label for="popup_terms_conditions_checkbox_style"><?php _e( 'Checkbox Style', 'popup-maker-terms-conditions-popups' );?></label></th>
				<td>
					<select name="popup_terms_conditions_checkbox_style" id="popup_terms_conditions_checkbox_style">
					<?php foreach( apply_filters( 'popmake_tcp_checkbox_style_options', array() ) as $option => $value ) : ?>
						<option
							value="<?php echo $value;?>"
							<?php selected( $value, popmake_get_popup_terms_conditions( $popup_id, 'checkbox_style' ) ); ?>
						><?php echo $option;?></option>
					<?php endforeach ?>
					</select>
					<p class="description"><?php _e( 'Choose the style of the checkbox.', 'popup-maker-terms-conditions-popups' );?></p>
				</td>
			</tr><?php
		}

		public function agree_text( $popup_id ) { ?>
			<tr class="terms-conditions-enabled">
				<th scope="row">
					<label for="popup_terms_conditions_agree_text">
						<?php _e( 'Agree Text', 'popup-maker-terms-conditions-popups' );?>
					</label>
				</th>
				<td>
					<input type="text" class="regular-text" name="popup_terms_conditions_agree_text" id="popup_terms_conditions_agree_text" value="<?php esc_attr_e( popmake_get_popup_terms_conditions( $popup_id, 'agree_text' ) ); ?>"/>
					<p class="description"><?php _e( 'This is the text label for the agree checkbox.', 'popup-maker-terms-conditions-popups' ); ?></p>
				</td>
			</tr><?php
		}

		public function force_agree( $popup_id ) { ?>
			<tr class="terms-conditions-enabled">
				<th scope="row"><?php _e( 'Force Agreement To View Page', 'popup-maker-terms-conditions-popups' );?></th>
				<td>
					<input type="checkbox" value="true" name="popup_terms_conditions_force_agree" id="popup_terms_conditions_force_agree" <?php checked( popmake_get_popup_terms_conditions( $popup_id, 'force_agree' ), 'true' );?>/>
					<label for="popup_terms_conditions_force_agree" class="description"><?php _e( 'Checking this will cause this to open on page load and force acceptance before viewing the page.', 'popup-maker-terms-conditions-popups' );?></label>
				</td>
			</tr><?php
		}

		public function force_read( $popup_id ) { ?>
			<tr class="terms-conditions-enabled">
				<th scope="row"><?php _e( 'Force User to Read Terms', 'popup-maker-terms-conditions-popups' );?></th>
				<td>
					<input type="checkbox" value="true" name="popup_terms_conditions_force_read" id="popup_terms_conditions_force_read" <?php checked( popmake_get_popup_terms_conditions( $popup_id, 'force_read' ), 'true' );?>/>
					<label for="popup_terms_conditions_force_read" class="description"><?php _e( 'Checking this will disable the agree checkbox until user has reached the end of the terms box.', 'popup-maker-terms-conditions-popups' );?></label>
				</td>
			</tr><?php
		}

		public function force_read_notice( $popup_id ) { ?>
			<tr class="terms-conditions-enabled">
				<th scope="row">
					<label for="popup_terms_conditions_force_read_notice">
						<?php _e( 'Force to Read Notice', 'popup-maker-terms-conditions-popups' );?>
					</label>
				</th>
				<td>
					<input type="text" class="regular-text" name="popup_terms_conditions_force_read_notice" id="popup_terms_conditions_force_read_notice" value="<?php esc_attr_e( popmake_get_popup_terms_conditions( $popup_id, 'force_read_notice' ) ); ?>"/>
					<p class="description"><?php _e( 'This is the text notice displayed if the user must read the terms.', 'popup-maker-terms-conditions-popups' ); ?></p>
				</td>
			</tr><?php
		}

		public function cookie_time( $popup_id ) { ?>
			<tr class="terms-conditions-enabled">
				<th scope="row">
					<label for="popup_terms_conditions_cookie_time">
						<?php _e( 'Cookie Time', 'popup-maker-terms-conditions-popups' );?>
					</label>
				</th>
				<td>
					<input type="text" class="regular-text" name="popup_terms_conditions_cookie_time" id="popup_terms_conditions_cookie_time" value="<?php esc_attr_e( popmake_get_popup_terms_conditions( $popup_id, 'cookie_time' ) ); ?>"/>
					<p class="description"><?php _e( 'Enter a plain english time before cookie expires. <br/>Example "364 days 23 hours 59 minutes 59 seconds" will reset just before 1 year exactly.', 'popup-maker-terms-conditions-popups' ); ?></p>
				</td>
			</tr><?php
		}

		public function cookie_path( $popup_id ) { ?>
			<tr class="terms-conditions-enabled">
				<th scope="row"><?php _e( 'Sitewide Cookie', 'popup-maker-terms-conditions-popups' );?></th>
				<td>
					<input type="checkbox" value="/" name="popup_terms_conditions_cookie_path" id="popup_terms_conditions_cookie_path" <?php checked( popmake_get_popup_terms_conditions( $popup_id, 'cookie_path' ), '/' ); ?>/>
					<label for="popup_terms_conditions_cookie_path" class="description"><?php _e( 'This will prevent the popup from appearing on any page until the cookie expires.', 'popup-maker-terms-conditions-popups' ); ?></label>
				</td>
			</tr><?php
		}

		public function cookie_key( $popup_id ) { ?>
			<tr class="terms-conditions-enabled">
				<th scope="row">
					<label for="popup_terms_conditions_cookie_key">
						<?php _e( 'Cookie Key', 'popup-maker-terms-conditions-popups' );?>
					</label>
				<td>
					<input type="text" value="<?php esc_attr_e( popmake_get_popup_terms_conditions( $popup_id, 'cookie_key' ) ); ?>" name="popup_terms_conditions_cookie_key" id="popup_terms_conditions_cookie_key" /><button type="button" class="popmake-reset-terms-conditions-cookie-key popmake-reset-cookie-key button button-primary large-button"></button>
					<p class="description"><?php _e( 'This changes the key used when setting and checking cookies. Resetting this will cause all existing cookies to be invalid.', 'popup-maker-terms-conditions-popups' );?></p>
				</td>
			</tr><?php
		}


    }
} // End if class_exists check