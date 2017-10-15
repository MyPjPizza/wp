<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'PopMake_Scroll_Triggered_Popups_Admin_Popup_Metabox_Fields' ) ) {

    /**
     * Main PopMake_Scroll_Triggered_Popups_Admin_Popup_Metabox_Fields class
     *
     * @since       1.0.0
     */
    class PopMake_Scroll_Triggered_Popups_Admin_Popup_Metabox_Fields {

        public function enabled( $popup_id ) { ?>
            <tr>
            <th scope="row"><?php _e( 'Enable Scroll Triggered Popups', 'popup-maker-scroll-triggered-popups' ); ?></th>
            <td>
                <input type="checkbox" value="true" name="popup_scroll_triggered_enabled"
                       id="popup_scroll_triggered_enabled" <?php checked( popmake_get_popup_scroll_triggered( $popup_id, 'enabled' ), 'true' ); ?>/>
                <label for="popup_scroll_triggered_enabled"
                       class="description"><?php _e( 'Checking this will cause popup to open during scroll.', 'popup-maker-scroll-triggered-popups' ); ?></label>
            </td>
            </tr><?php
        }

        public function trigger( $popup_id ) { ?>
            <tr class="scroll-triggered-enabled">
            <th scope="row"><label
                        for="popup_scroll_triggered_trigger"><?php _e( 'Trigger Type', 'popup-maker-scroll-triggered-popups' ); ?></label>
            </th>
            <td>
                <select name="popup_scroll_triggered_trigger" id="popup_scroll_triggered_trigger">
                    <?php foreach ( apply_filters( 'popmake_stp_scroll_trigger_options', array() ) as $option => $value ) : ?>
                        <option
                                value="<?php echo $value; ?>"
                                <?php selected( $value, popmake_get_popup_scroll_triggered( $popup_id, 'trigger' ) ); ?>
                        ><?php echo $option; ?></option>
                    <?php endforeach ?>
                </select>
                <p class="description"><?php _e( 'Choose the type of trigger to be used for opening this popup.', 'popup-maker-scroll-triggered-popups' ); ?></p>
            </td>
            </tr><?php
        }

        public function distance( $popup_id ) { ?>
            <tr class="scroll-triggered-enabled distance-only">
            <th scope="row">
                <label for="popup_scroll_triggered_distance"><?php _e( 'Distance', 'popup-maker-scroll-triggered-popups' ); ?></label>
            </th>
            <td>
                <input type="text" readonly
                       value="<?php esc_attr_e( popmake_get_popup_scroll_triggered( $popup_id, 'distance' ) ) ?>"
                       name="popup_scroll_triggered_distance"
                       id="popup_scroll_triggered_distance"
                       class="popmake-range-manual"
                       step="<?php esc_attr_e( apply_filters( 'popmake_popup_scroll_triggered_distance_step', 1 ) ); ?>"
                       min="<?php esc_attr_e( apply_filters( 'popmake_popup_scroll_triggered_distance_min', 0 ) ); ?>"
                       max="<?php esc_attr_e( apply_filters( 'popmake_popup_scroll_triggered_distance_max', 100 ) ); ?>"
                />
					<span class="range-value-unit regular-text" style="width: 50px;">
						<select name="popup_scroll_triggered_unit" id="popup_scroll_triggered_unit">
                            <?php foreach ( apply_filters( 'popmake_scroll_triggered_size_unit_options', array() ) as $option => $value ) : ?>
                                <option
                                        value="<?php echo $value; ?>"
                                        <?php selected( $value, popmake_get_popup_scroll_triggered( $popup_id, 'unit' ) ); ?>
                                ><?php echo $option; ?></option>
                            <?php endforeach ?>
                        </select>
					</span>
                <p class="description"><?php _e( 'Choose how far users scroll before popup opens.', 'popup-maker-scroll-triggered-popups' ) ?></p>
            </td>
            </tr><?php
        }

        public function trigger_point( $popup_id ) { ?>
            <tr class="scroll-triggered-enabled">
            <th scope="row"><label
                        for="popup_scroll_triggered_trigger_point"><?php _e( 'Trigger Point', 'popup-maker-scroll-triggered-popups' ); ?></label>
            </th>
            <td>
                <select name="popup_scroll_triggered_trigger_point" id="popup_scroll_triggered_trigger_point">
                    <?php foreach ( apply_filters( 'popmake_stp_trigger_point_options', array() ) as $option => $value ) : ?>
                        <option
                                value="<?php echo $value; ?>"
                                <?php selected( $value, popmake_get_popup_scroll_triggered( $popup_id, 'trigger_point' ) ); ?>
                        ><?php echo $option; ?></option>
                    <?php endforeach ?>
                </select>
                <p class="description"><?php _e( 'This changes the default trigger detection point.', 'popup-maker-scroll-triggered-popups' ); ?></p>
            </td>
            </tr><?php
        }

        public function trigger_element( $popup_id ) { ?>
            <tr class="scroll-triggered-enabled element-only">
            <th scope="row">
                <label for="popup_scroll_triggered_trigger_element">
                    <?php _e( 'Trigger Element', 'popup-maker-scroll-triggered-popups' ); ?>
                </label>
            </th>
            <td>
                <input type="text" class="regular-text" name="popup_scroll_triggered_trigger_element"
                       id="popup_scroll_triggered_trigger_element"
                       value="<?php esc_attr_e( popmake_get_popup_scroll_triggered( $popup_id, 'trigger_element' ) ); ?>"/>
                <p class="description"><?php _e( 'CSS / jQuery Selector that will trigger the popup once the user scrolls it on screen.', 'popup-maker-scroll-triggered-popups' ); ?></p>
            </td>
            </tr><?php
        }

        public function close_on_up( $popup_id ) { ?>
            <tr>
            <th scope="row"><?php _e( 'Close When Scrolled Back Up', 'popup-maker-scroll-triggered-popups' ); ?></th>
            <td>
                <input type="checkbox" value="true" name="popup_scroll_triggered_close_on_up"
                       id="popup_scroll_triggered_close_on_up" <?php checked( popmake_get_popup_scroll_triggered( $popup_id, 'close_on_up' ), 'true' ); ?>/>
                <label for="popup_scroll_triggered_close_on_up"
                       class="description"><?php _e( 'Checking this will cause popup to scroll when user scrolls back up.', 'popup-maker-scroll-triggered-popups' ); ?></label>
            </td>
            </tr><?php
        }

        public function cookie_trigger( $popup_id ) { ?>
            <tr class="scroll-triggered-enabled">
            <th scope="row">
                <label for="popup_scroll_triggered_cookie_trigger">
                    <?php _e( 'Cookie Trigger', 'popup-maker-scroll-triggered-popups' ); ?>
                </label>
            </th>
            <td>
                <select name="popup_scroll_triggered_cookie_trigger" id="popup_scroll_triggered_cookie_trigger">
                    <?php foreach ( apply_filters( 'popmake_cookie_trigger_options', array() ) as $option => $value ) : ?>
                        <option
                                value="<?php echo $value; ?>"
                                <?php selected( $value, popmake_get_popup_scroll_triggered( $popup_id, 'cookie_trigger' ) ); ?>
                        ><?php echo $option; ?></option>
                    <?php endforeach ?>
                </select>
                <p class="description"><?php _e( 'When do you want to create the cookie.', 'popup-maker-scroll-triggered-popups' ) ?></p>
            </td>
            </tr><?php
        }

        public function cookie_time( $popup_id ) { ?>
            <tr class="scroll-triggered-enabled">
            <th scope="row">
                <label for="popup_scroll_triggered_cookie_time">
                    <?php _e( 'Cookie Time', 'popup-maker-scroll-triggered-popups' ); ?>
                </label>
            </th>
            <td>
                <input type="text" class="regular-text" name="popup_scroll_triggered_cookie_time"
                       id="popup_scroll_triggered_cookie_time"
                       value="<?php esc_attr_e( popmake_get_popup_scroll_triggered( $popup_id, 'cookie_time' ) ); ?>"/>
                <p class="description"><?php _e( 'Enter a plain english time before cookie expires. <br/>Example "364 days 23 hours 59 minutes 59 seconds" will reset just before 1 year exactly.', 'popup-maker-scroll-triggered-popups' ); ?></p>
            </td>
            </tr><?php
        }

        public function cookie_path( $popup_id ) { ?>
            <tr class="scroll-triggered-enabled">
            <th scope="row"><?php _e( 'Sitewide Cookie', 'popup-maker-scroll-triggered-popups' ); ?></th>
            <td>
                <input type="checkbox" value="/" name="popup_scroll_triggered_cookie_path"
                       id="popup_scroll_triggered_cookie_path" <?php checked( popmake_get_popup_scroll_triggered( $popup_id, 'cookie_path' ), '/' ); ?>/>
                <label for="popup_scroll_triggered_cookie_path"
                       class="description"><?php _e( 'This will prevent the popup from appearing on any page until the cookie expires.', 'popup-maker-scroll-triggered-popups' ); ?></label>
            </td>
            </tr><?php
        }

        public function cookie_key( $popup_id ) { ?>
            <tr class="scroll-triggered-enabled">
            <th scope="row">
                <label for="popup_scroll_triggered_cookie_key">
                    <?php _e( 'Cookie Key', 'popup-maker-scroll-triggered-popups' ); ?>
                </label>
            <td>
                <input type="text"
                       value="<?php esc_attr_e( popmake_get_popup_scroll_triggered( $popup_id, 'cookie_key' ) ); ?>"
                       name="popup_scroll_triggered_cookie_key" id="popup_scroll_triggered_cookie_key"/>
                <button type="button"
                        class="popmake-reset-scroll-triggered-cookie-key popmake-reset-cookie-key button button-primary large-button"></button>
                <p class="description"><?php _e( 'This changes the key used when setting and checking cookies. Resetting this will cause all existing cookies to be invalid.', 'popup-maker-scroll-triggered-popups' ); ?></p>
            </td>
            </tr><?php
        }


    }
} // End if class_exists check