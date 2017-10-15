<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PopMake_Terms_Conditions_Popups_Admin_Popup_Metaboxes' ) ) {

    /**
     * Main PopMake_Terms_Conditions_Popups_Admin_Popup_Metaboxes class
     *
     * @since       1.0.0
     */
    class PopMake_Terms_Conditions_Popups_Admin_Popup_Metaboxes {

        public function register() {
            /** Scroll Triggered Popups Meta **/
            add_meta_box( 'popmake_popup_terms_conditions', __( 'Terms & Conditions Popups Settings', 'popup-maker-terms-conditions-popups' ),  array( $this, 'terms_conditions_meta_box' ), 'popup', 'normal', 'high' );
        }

        public function meta_fields( $fields ) {
            return array_merge( $fields, array(
                'popup_terms_conditions_defaults_set',
            ));
        }

        public function meta_field_groups( $groups ) {
            return array_merge( $groups, array(
                'terms_conditions',
            ));
        }

        public function group_terms_conditions( $fields ) {
            return array_merge( $fields, array(
                'enabled',
                'checkbox_style',
                'agree_text',
                'force_agree',
                'force_read',
                'force_read_notice',
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

        public function terms_conditions_defaults( $defaults ) {
            return array_merge( $defaults, array(
                'enabled'           => NULL,
                'checkbox_style'    => 'classic',
                'agree_text'        => __( 'I Agree', 'popup-maker-terms-conditions-popups' ),
                'force_agree'       => NULL,
                'force_read'        => NULL,
                'force_read_notice' => __( 'You need to read to the bottom of these terms and conditions before you can continue.', 'popup-maker-terms-conditions-popups' ),
                'cookie_time'       => '1 month',
                'cookie_path'       => '/',
                'cookie_key'        => '',
            ));
        }

        public function checkbox_style_options( $options ) {
            return array_merge( $options, array(
                __( 'Classic', 'popup-maker-terms-conditions-popups' )   => 'classic',
                __( 'Rounded 1', 'popup-maker-terms-conditions-popups' ) => 'roundedOne',
                __( 'Rounded 2', 'popup-maker-terms-conditions-popups' ) => 'roundedTwo',
                __( 'Square 1', 'popup-maker-terms-conditions-popups' )  => 'squaredOne',
                __( 'Square 2', 'popup-maker-terms-conditions-popups' )  => 'squaredTwo',
                __( 'Square 3', 'popup-maker-terms-conditions-popups' )  => 'squaredThree',
                __( 'Square 4', 'popup-maker-terms-conditions-popups' )  => 'squaredFour',
            ));
        }


        /** Popup Configuration *****************************************************************/
        /**
         * Terms & Conditions Popups Metabox
         *
         * Extensions (as well as the core plugin) can add items to the popup display
         * configuration metabox via the `popmake_popup_terms_conditions_meta_box_fields` action.
         *
         * @since 1.0
         * @return void
         */
        function terms_conditions_meta_box() {
            global $post;?>
            <input type="hidden" name="popup_terms_conditions_defaults_set" value="true" />
            <div id="popmake_popup_terms_conditions_fields" class="popmake_meta_table_wrap">
                <table class="form-table">
                    <tbody>
                        <?php do_action( 'popmake_popup_terms_conditions_meta_box_fields', $post->ID );?>
                    </tbody>
                </table>
            </div><?php
        }


    }
} // End if class_exists check