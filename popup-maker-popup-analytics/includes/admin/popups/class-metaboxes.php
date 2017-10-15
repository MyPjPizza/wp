<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'PopMake_Popup_Analytics_Admin_Popup_Metaboxes' ) ) {

    /**
     * Main PopMake_Popup_Analytics_Admin_Popup_Metaboxes class
     *
     * @since       1.0.0
     */
    class PopMake_Popup_Analytics_Admin_Popup_Metaboxes {

        public function register() {
            /** Basic Statistics Meta **/
            add_meta_box( 'popmake_popup_stats', __( 'Analytics & Stats', 'popup-maker-popup-analytics' ),  array( $this, 'stats_meta_box' ), 'popup', 'side', 'high' );
            add_meta_box( 'popmake_popup_conversions', __( 'Conversion Settings', 'popup-maker-popup-analytics' ),  array( $this, 'conversions_meta_box' ), 'popup', 'normal', 'high' );
            /** Google Analytics Settings Meta **/

            if( popmake_get_option( 'popmake_pa_ga_enabled', false ) && popmake_get_option( 'popmake_pa_ga_tid', '' ) != '' ) {
                add_meta_box( 'popmake_popup_google_analytics', __( 'Google Analytics Settings', 'popup-maker-popup-analytics' ),  array( $this, 'analytics_meta_box' ), 'popup', 'normal', 'high' );
            }
        }

        public function meta_fields( $fields ) {
            return array_merge( $fields, array(
                'popup_analytics_defaults_set',
            ) );
        }

        public function meta_field_groups( $groups ) {
            return array_merge( $groups, array(
                'analytics',
            ) );
        }

        public function meta_field_group_analytics( $fields ) {
            return array_merge( $fields, array(
                'convert_on',

                'open_event_override',
                'open_event_category',
                'open_event_action',
                'open_event_label',
                'open_event_value',

                'close_event_override',
                'close_event_category',
                'close_event_action',
                'close_event_label',
                'close_event_value',

                'conversion_event_override',
                'conversion_event_category',
                'conversion_event_action',
                'conversion_event_label',
                'conversion_event_value',
            ) );
        }


        public function cookie_trigger_options( $options ) {
            return array_merge( $options, array(
                __( 'On Conversion', 'popup-maker-popup-analytics' ) => 'conversion',
            ) );
        }


        public function convert_on_options( $options ) {
            return array_merge( $options, array(
                __( 'None / Auto', 'popup-maker-popup-analytics' ) => '',
                __( 'Form Submit', 'popup-maker-popup-analytics' ) => 'form_submit',
                __( 'Button Click', 'popup-maker-popup-analytics' ) => 'button_click',
                __( 'Link Click', 'popup-maker-popup-analytics' ) => 'link_click',
            ) );
        }


        /**
         * Checks for reset checkbox and if set resets stats for current popup.
         *
         * @since 1.0.3
         * @return void
         */
        public function save_popup( $popup_id, $post ) {
            if( isset( $_POST['popup_analytics_reset'] ) ) {
                popmake_pa_reset_tracking_data( $popup_id );
            }
        }


        /**
         * Popup Google Anlytics Settings Popups Metabox
         *
         * Extensions (as well as the core plugin) can add items to the popup display
         * configuration metabox via the `popmake_popup_analytics_meta_box_fields` action.
         *
         * @since 1.0
         * @return void
         */
        public function analytics_meta_box() {
            global $post; ?>
            <input type="hidden" name="popup_analytics_defaults_set" value="true" />
            <div id="popmake_popup_analytics_fields" class="popmake_meta_table_wrap">
                <table class="form-table">
                    <tbody>
                        <?php do_action( 'popmake_popup_analytics_meta_box_fields', $post->ID );?>
                    </tbody>
                </table>
            </div><?php
        }

        public function event_meta_box_fields( $popup_id ) { ?>
            <tr>
                <th scope="row"><?php _e( 'Override Open Event Info', 'popup-maker-popup-analytics' );?></th>
                <td>
                    <input type="checkbox" value="true" name="popup_analytics_open_event_override" id="popup_analytics_open_event_override" <?php echo popmake_get_popup_analytics( $popup_id, 'open_event_override' ) ? 'checked="checked" ' : '';?>/>
                    <label for="popup_analytics_open_event_override" class="description"><?php _e( 'This will allow custom values for GA Events when popup is opened.', 'popup-maker-popup-analytics' );?></label>
                </td>
            </tr>
            <tr class="analytics-open-overide-only">
                <th scope="row">
                    <label for="popup_analytics_open_event_category">
                        <?php _e( 'Event Category', 'popup-maker-popup-analytics' );?>
                    </label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="popup_analytics_open_event_category" id="popup_analytics_open_event_category" value="<?php esc_attr_e(popmake_get_popup_analytics( $popup_id, 'open_event_category' ))?>"/>
                    <p class="description"><?php _e( 'Enter custom category text.', 'popup-maker-popup-analytics' )?></p>
                </td>
            </tr>
            <tr class="analytics-open-overide-only">
                <th scope="row">
                    <label for="popup_analytics_open_event_action">
                        <?php _e( 'Event Action', 'popup-maker-popup-analytics' );?>
                    </label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="popup_analytics_open_event_action" id="popup_analytics_open_event_action" value="<?php esc_attr_e(popmake_get_popup_analytics( $popup_id, 'open_event_action' ))?>"/>
                    <p class="description"><?php _e( 'Enter custom action text.', 'popup-maker-popup-analytics' )?></p>
                </td>
            </tr>
            <tr class="analytics-open-overide-only">
                <th scope="row">
                    <label for="popup_analytics_open_event_label">
                        <?php _e( 'Event Label', 'popup-maker-popup-analytics' );?>
                    </label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="popup_analytics_open_event_label" id="popup_analytics_open_event_label" value="<?php esc_attr_e(popmake_get_popup_analytics( $popup_id, 'open_event_label' ))?>"/>
                    <p class="description"><?php _e( 'Enter custom label text.', 'popup-maker-popup-analytics' )?></p>
                </td>
            </tr>
            <tr class="analytics-open-overide-only">
                <th scope="row">
                    <value for="popup_analytics_open_event_value">
                        <?php _e( 'Event Value', 'popup-maker-popup-analytics' );?>
                    </value>
                </th>
                <td>
                    <input type="text" class="regular-text" name="popup_analytics_open_event_value" id="popup_analytics_open_event_value" value="<?php esc_attr_e(popmake_get_popup_analytics( $popup_id, 'open_event_value' ))?>"/>
                    <p class="description"><?php _e( 'Enter custom value text.', 'popup-maker-popup-analytics' )?></p>
                </td>
            </tr>
            <?php do_action( 'popmake_pa_meta_box_after_open_event' ); ?>
            <tr>
                <th scope="row"><?php _e( 'Override Close Event Info', 'popup-maker-popup-analytics' );?></th>
                <td>
                    <input type="checkbox" value="true" name="popup_analytics_close_event_override" id="popup_analytics_close_event_override" <?php echo popmake_get_popup_analytics( $popup_id, 'close_event_override' ) ? 'checked="checked" ' : '';?>/>
                    <label for="popup_analytics_close_event_override" class="description"><?php _e( 'This will allow custom values for GA Events when popup is closed.', 'popup-maker-popup-analytics' );?></label>
                </td>
            </tr>
            <tr class="analytics-close-overide-only">
                <th scope="row">
                    <label for="popup_analytics_close_event_category">
                        <?php _e( 'Event Category', 'popup-maker-popup-analytics' );?>
                    </label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="popup_analytics_close_event_category" id="popup_analytics_close_event_category" value="<?php esc_attr_e(popmake_get_popup_analytics( $popup_id, 'close_event_category' ))?>"/>
                    <p class="description"><?php _e( 'Enter custom category text.', 'popup-maker-popup-analytics' )?></p>
                </td>
            </tr>
            <tr class="analytics-close-overide-only">
                <th scope="row">
                    <label for="popup_analytics_close_event_action">
                        <?php _e( 'Event Action', 'popup-maker-popup-analytics' );?>
                    </label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="popup_analytics_close_event_action" id="popup_analytics_close_event_action" value="<?php esc_attr_e(popmake_get_popup_analytics( $popup_id, 'close_event_action' ))?>"/>
                    <p class="description"><?php _e( 'Enter custom action text.', 'popup-maker-popup-analytics' )?></p>
                </td>
            </tr>
            <tr class="analytics-close-overide-only">
                <th scope="row">
                    <label for="popup_analytics_close_event_label">
                        <?php _e( 'Event Label', 'popup-maker-popup-analytics' );?>
                    </label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="popup_analytics_close_event_label" id="popup_analytics_close_event_label" value="<?php esc_attr_e(popmake_get_popup_analytics( $popup_id, 'close_event_label' ))?>"/>
                    <p class="description"><?php _e( 'Enter custom label text.', 'popup-maker-popup-analytics' )?></p>
                </td>
            </tr>
            <tr class="analytics-close-overide-only">
                <th scope="row">
                    <value for="popup_analytics_close_event_value">
                        <?php _e( 'Event Value', 'popup-maker-popup-analytics' );?>
                    </value>
                </th>
                <td>
                    <input type="text" class="regular-text" name="popup_analytics_close_event_value" id="popup_analytics_close_event_value" value="<?php esc_attr_e(popmake_get_popup_analytics( $popup_id, 'close_event_value' ))?>"/>
                    <p class="description"><?php _e( 'Enter custom value text.', 'popup-maker-popup-analytics' )?></p>
                </td>
            </tr>
            <?php do_action( 'popmake_pa_meta_box_after_close_event' ); ?>
            <tr>
                <th scope="row"><?php _e( 'Override Close Event Info', 'popup-maker-popup-analytics' );?></th>
                <td>
                    <input type="checkbox" value="true" name="popup_analytics_conversion_event_override" id="popup_analytics_conversion_event_override" <?php echo popmake_get_popup_analytics( $popup_id, 'conversion_event_override' ) ? 'checked="checked" ' : '';?>/>
                    <label for="popup_analytics_conversion_event_override" class="description"><?php _e( 'This will allow custom values for GA Events when a conversion occurs in this popup.', 'popup-maker-popup-analytics' );?></label>
                </td>
            </tr>
            <tr class="analytics-conversion-overide-only">
                <th scope="row">
                    <label for="popup_analytics_conversion_event_category">
                        <?php _e( 'Event Category', 'popup-maker-popup-analytics' );?>
                    </label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="popup_analytics_conversion_event_category" id="popup_analytics_conversion_event_category" value="<?php esc_attr_e(popmake_get_popup_analytics( $popup_id, 'conversion_event_category' ))?>"/>
                    <p class="description"><?php _e( 'Enter custom category text.', 'popup-maker-popup-analytics' )?></p>
                </td>
            </tr>
            <tr class="analytics-conversion-overide-only">
                <th scope="row">
                    <label for="popup_analytics_conversion_event_action">
                        <?php _e( 'Event Action', 'popup-maker-popup-analytics' );?>
                    </label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="popup_analytics_conversion_event_action" id="popup_analytics_conversion_event_action" value="<?php esc_attr_e(popmake_get_popup_analytics( $popup_id, 'conversion_event_action' ))?>"/>
                    <p class="description"><?php _e( 'Enter custom action text.', 'popup-maker-popup-analytics' )?></p>
                </td>
            </tr>
            <tr class="analytics-conversion-overide-only">
                <th scope="row">
                    <label for="popup_analytics_conversion_event_label">
                        <?php _e( 'Event Label', 'popup-maker-popup-analytics' );?>
                    </label>
                </th>
                <td>
                    <input type="text" class="regular-text" name="popup_analytics_conversion_event_label" id="popup_analytics_conversion_event_label" value="<?php esc_attr_e(popmake_get_popup_analytics( $popup_id, 'conversion_event_label' ))?>"/>
                    <p class="description"><?php _e( 'Enter custom label text.', 'popup-maker-popup-analytics' )?></p>
                </td>
            </tr>
            <tr class="analytics-conversion-overide-only">
                <th scope="row">
                    <value for="popup_analytics_conversion_event_value">
                        <?php _e( 'Event Value', 'popup-maker-popup-analytics' );?>
                    </value>
                </th>
                <td>
                    <input type="text" class="regular-text" name="popup_analytics_conversion_event_value" id="popup_analytics_conversion_event_value" value="<?php esc_attr_e(popmake_get_popup_analytics( $popup_id, 'conversion_event_value' ))?>"/>
                    <p class="description"><?php _e( 'Enter custom value text.', 'popup-maker-popup-analytics' )?></p>
                </td>
            </tr>
            <?php do_action( 'popmake_pa_meta_box_after_conversion_event' );
        }

        /**
         * Popup Stats Metabox
         *
         * Extensions (as well as the core plugin) can add items to the popup display
         * configuration metabox via the `popmake_popup_stats_meta_box_fields` action.
         *
         * @since 1.0
         * @return void
         */
        public function stats_meta_box() {
            global $post; ?>
            <div id="popmake_popup_stats_fields" class="popmake_meta_table_wrap">
                <table class="form-table">
                    <tbody>
                        <?php do_action( 'popmake_popup_stats_meta_box_fields', $post->ID );?>
                    </tbody>
                </table>
            </div><?php
        }

        public function stats_meta_box_fields( $popup_id ) {
            $opened_count = get_post_meta( $popup_id, 'popup_analytic_opened_count', true);
            $closed_count = get_post_meta( $popup_id, 'popup_analytic_closed_count', true);
            $conversion_count = get_post_meta( $popup_id, 'popup_analytic_conversion_count', true);
            $conversion_rate = get_post_meta( $popup_id, 'popup_analytic_conversion_rate', true);
            $last_opened = get_post_meta( $popup_id, 'popup_analytic_last_opened', true);
            $avg_time_open = get_post_meta( $popup_id, 'popup_analytic_avg_time_open', true);
            $avg_conversion_time = get_post_meta( $popup_id, 'popup_analytic_avg_conversion_time', true); ?>
            <tr>
                <td colspan="2"><strong><?php _e( 'Views', 'popup-maker-popup-analytics' );?></strong></td>
            </tr>
            <tr>
                <td scope="row"><strong><?php _e( 'Count', 'popup-maker-popup-analytics' );?></strong></td>
                <td><?php echo $opened_count != '' ? $opened_count : 0; ?></td>
            </tr>
            <tr>
                <td scope="row"><strong><?php _e( 'Avg Time', 'popup-maker-popup-analytics' );?></strong></td>
                <td><?php echo $avg_time_open != '' ? formatMilliseconds( $avg_time_open ) : __( 'N/A', 'popup-maker-popup-analytics;'); ?></td>
            </tr>
            <tr>
                <td scope="row" style="vertical-align: top;"><strong><?php _e( 'Last View', 'popup-maker-popup-analytics' );?></strong></td>
                <td><?php echo $last_opened != '' ? date( 'm/d/Y h:ia', $last_opened ) : __( 'N/A', 'popup-maker-popup-analytics;'); ?></td>
            </tr>
            <tr>
                <td colspan="2"><hr /></td>
            </tr>
            <tr>
                <td colspan="2"><strong><?php _e( 'Conversions', 'popup-maker-popup-analytics' );?></strong></td>
            </tr>
            <tr>
                <td scope="row"><strong><?php _e( 'Count', 'popup-maker-popup-analytics' );?></strong></td>
                <td><?php echo $conversion_count != '' ? $conversion_count : 0; ?></td>
            </tr>
            <tr>
                <td scope="row"><strong><?php _e( 'Conv Rate', 'popup-maker-popup-analytics' );?></strong></td>
                <td><?php echo $conversion_count > 0 ? round( $conversion_rate, 3 ) .'%' : 'N/A'; ?></td>
            </tr>
            <tr>
                <td scope="row"><strong><?php _e( 'Avg Time', 'popup-maker-popup-analytics' );?></strong></td>
                <td><?php echo $conversion_count > 0 ? formatMilliseconds( $avg_conversion_time ) : __( 'N/A', 'popup-maker-popup-analytics;'); ?></td>
            </tr>
            <tr>
                <td scope="row"><label for="popup_analytics_reset">Reset Data?</label></td>
                <td><input id="popup_analytics_reset" name="popup_analytics_reset" type="checkbox" value="true"/></td> 
            </tr><?php
        }


        /**
         * Popup Conversions Metabox
         *
         * Extensions (as well as the core plugin) can add items to the popup conversions
         * configuration metabox via the `popmake_popup_conversions_meta_box_fields` action.
         *
         * @since 1.0
         * @return void
         */
        public function conversions_meta_box() {
            global $post; ?>
            <div id="popmake_popup_conversions_fields" class="popmake_meta_table_wrap">
                <table class="form-table">
                    <tbody>
                        <?php do_action( 'popmake_popup_conversions_meta_box_fields', $post->ID );?>
                    </tbody>
                </table>
            </div><?php
        }

        public function conversions_meta_box_fields( $popup_id ) { 
            $convert_on = popmake_get_popup_analytics( $popup_id, 'convert_on'); ?>
            <tr>
                <th scope="row">
                    <label for="popup_analytics_convert_on">
                        <?php _e( 'Convert On', 'popup-maker-popup-analytics' ); ?>
                    </label>
                </th>
                <td>
                    <select name="popup_analytics_convert_on" id="popup_analytics_convert_on">
                    <?php foreach( apply_filters( 'popmake_pa_convert_on_options', array() ) as $option => $value ) : ?>
                        <option value="<?php echo $value;?>" <?php selected( $convert_on, $value ); ?>><?php echo $option; ?></option>
                    <?php endforeach ?>
                    </select>
                    <p class="description"><?php _e( 'Choose what will count as a conversion. Choose <code>None / Auto</code> if you are using one of the supported form plugins.', 'popup-maker-popup-analytics' ); ?></p>
                </td>
            </tr><?php
        }

    }
} // End if class_exists check