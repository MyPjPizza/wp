<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PopMake_Scroll_Triggered_Popups_Admin_Popup_Metaboxes' ) ) {

    /**
     * Main PopMake_Scroll_Triggered_Popups_Admin_Popup_Metaboxes class
     *
     * @since       1.0.0
     */
    class PopMake_Scroll_Triggered_Popups_Admin_Popup_Metaboxes {

        public function register() {
            /** Scroll Triggered Popups Meta **/
            add_meta_box( 'popmake_popup_scroll_triggered', __( 'Scroll Triggered Popups Settings', 'popup-maker-scroll-triggered-popups' ),  array( $this, 'scroll_triggered_meta_box' ), 'popup', 'normal', 'high' );
        }

        public function meta_fields( $fields ) {
            return array_merge( $fields, array(
                'popup_scroll_triggered_defaults_set',
            ));
        }

        public function meta_field_groups( $groups ) {
            return array_merge( $groups, array(
                'scroll_triggered',
            ));
        }

        public function group_scroll_triggered( $fields ) {
            return array_merge( $fields, array(
                'enabled',
                'trigger',
                'trigger_point',
                'distance',
                'unit',
                'trigger_element',
                'close_on_up',
                'cookie_trigger',
                'cookie_time',
                'cookie_path',
                'cookie_key'
            ));
        }

        public function save_popup( $field = '' ) {
            if( $field == '' ) {
                $field = uniqid();
            }
            return $field;
        }

        public function scroll_triggered_defaults( $defaults ) {
            return array_merge( $defaults, array(
                'enabled'         => NULL,
                'trigger'         => 'distance',
                'trigger_point'   => '',
                'distance'        => 75,
                'unit'            => '%',
                'trigger_element' => '',
                'close_on_up'     => null,
                'cookie_trigger'  => 'close',
                'cookie_time'     => '1 month',
                'cookie_path'     => '/',
                'cookie_key'      => '',
            ));
        }


        public function scroll_triggered_size_unit_options( $options ) {
            $options = array_merge( apply_filters( 'popmake_size_unit_options', array() ), $options );
            unset( $options[__( 'EM', 'popup-maker' )] );
            return $options;
        }

        public function scroll_trigger_options( $options ) {
            return array_merge( $options, array(
                __( 'Distance', 'popup-maker-scroll-triggered-popups' ) => 'distance',
                __( 'Element', 'popup-maker-scroll-triggered-popups' )  => 'element',
                __( 'Manual', 'popup-maker-scroll-triggered-popups' )   => 'manual'
            ));
        }

        public function trigger_point_options( $options ) {
            return array_merge( $options, array(
                __( 'Auto', 'popup-maker-scroll-triggered-popups' ) => '',
                __( 'Top', 'popup-maker-scroll-triggered-popups' )  => 'top',
                __( 'Bottom', 'popup-maker-scroll-triggered-popups' )  => 'bottom',
                __( 'Floating', 'popup-maker-scroll-triggered-popups' )   => 'floating'
            ));
        }

        /** Popup Configuration *****************************************************************/
        /**
         * Popup Scroll Triggered Popups Metabox
         *
         * Extensions (as well as the core plugin) can add items to the popup display
         * configuration metabox via the `popmake_popup_scroll_triggered_meta_box_fields` action.
         *
         * @since 1.0
         * @return void
         */
        function scroll_triggered_meta_box() {
            global $post;?>
            <input type="hidden" name="popup_scroll_triggered_defaults_set" value="true" />
            <div id="popmake_popup_scroll_triggered_fields" class="popmake_meta_table_wrap">
                <table class="form-table">
                    <tbody>
                        <?php do_action( 'popmake_popup_scroll_triggered_meta_box_fields', $post->ID );?>
                    </tbody>
                </table>
            </div><?php
        }


    }
} // End if class_exists check