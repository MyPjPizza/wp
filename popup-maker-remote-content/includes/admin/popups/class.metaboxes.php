<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PopMake_Remote_Content_Admin_Popup_Metaboxes' ) ) {

    /**
     * Main PopMake_Remote_Content_Admin_Popup_Metaboxes class
     *
     * @since       1.0.0
     */
    class PopMake_Remote_Content_Admin_Popup_Metaboxes {

        public function __construct() {
            add_action( 'add_meta_boxes', array( $this, 'register' ) );
            add_filter( 'popmake_popup_meta_fields', array( $this, 'meta_fields' ) );
            add_filter( 'popmake_popup_meta_field_groups', array( $this, 'meta_field_groups' ) );
            add_filter( 'popmake_popup_meta_field_group_remote_content', array( $this, 'meta_field_group_remote_content' ) );
            add_filter( 'popmake_popup_remote_content_defaults', array( $this, 'defaults' ) );
            add_filter( 'popmake_remote_content_type_options', array( $this, 'type_options' ) );
            add_filter( 'popmake_remote_content_loading_icon_options', array( $this, 'loading_icon_options' ) );
        }
        
        public function register() {
            /** Exit Popup Meta **/
            add_meta_box( 'popmake_remote_content', __( 'Remote Content', popmake_rc()->textdomain ),  array( $this, 'render_meta_box' ), 'popup', 'normal', 'high' );
        }

        public function meta_fields( $fields ) {
            return array_merge( $fields, array(
                'popup_remote_content_defaults_set',
            ) );
        }

        public function meta_field_groups( $groups ) {
            return array_merge( $groups, array(
                'remote_content',
            ) );
        }

        public function meta_field_group_remote_content( $fields ) {
            return array_merge( $fields, array(
                'enabled',
                'type',
                'function_name',
                'css_selector',
                'loading_icon',
            ));
        }

        public function defaults( $defaults ) {
            return array_merge( $defaults, array(
                'enabled' => NULL,
                'type' => 'loadselector',
                'function_name' => '',
                'css_selector' => '',
                'loading_icon' => 'lines-1',
            ));
        }

        public function type_options( $options ) {
            return array_merge( $options, array(
                __( 'Load From URL', popmake_rc()->textdomain ) => 'loadselector',
                __( 'IFrame', popmake_rc()->textdomain ) => 'iframe',
                __( 'AJAX', popmake_rc()->textdomain ) => 'ajax',
            ) );
        }

        public function loading_icon_options( $options ) {
            return array_merge( $options, array(
                __( 'Lines: Growing', popmake_rc()->textdomain ) => 'lines-1',
                __( 'Dots: Growing', popmake_rc()->textdomain ) => 'dots-1',
                //__( 'Circles: Streaking', popmake_rc()->textdomain ) => 'circles-1',
                //__( 'Circles: Chasing Tail', popmake_rc()->textdomain ) => 'circles-2',
                __( 'Circles: Dots Chasing', popmake_rc()->textdomain ) => 'circles-3',
                __( 'Circles: Dots Fading', popmake_rc()->textdomain ) => 'circles-4',
                __( 'Circles: Dots Streaking', popmake_rc()->textdomain ) => 'circles-5',
                __( 'Circles: Racetrack', popmake_rc()->textdomain ) => 'circles-6',
            ) );
        }


        /**
         * Popup Exit Intent Popups Metabox
         *
         * Extensions (as well as the core plugin) can add items to the popup display
         * configuration metabox via the `popmake_popup_exit_intent_meta_box_fields` action.
         *
         * @since 1.0
         * @return void
         */
        public function render_meta_box() {
            global $post; ?>
            <input type="hidden" name="popup_remote_content_defaults_set" value="true" />
            <div id="popmake_remote_content_fields" class="popmake_meta_table_wrap">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php _e( 'Enable Remote Content', popmake_rc()->textdomain );?></th>
                        <td>
                            <input type="checkbox" value="true" name="popup_remote_content_enabled" id="popup_remote_content_enabled" <?php checked( popmake_get_popup_remote_content( $post->ID, 'enabled' ), 'true' ); ?>/>
                            <label for="popup_remote_content_enabled" class="description"><?php _e( 'This enables Remote Content for this popup.', popmake_rc()->textdomain );?></label>
                        </td>
                    </tr>
                    <tr class="remote-content-enabled">
                        <th scope="row">
                            <label for="popup_remote_content_type"><?php _e( 'Type', popmake_rc()->textdomain );?></label>
                        </th>
                        <td>
                            <select name="popup_remote_content_type" id="popup_remote_content_type">
                                <?php foreach( apply_filters( 'popmake_remote_content_type_options', array() ) as $option => $value ) : ?>
                                    <option
                                        value="<?php echo $value;?>"
                                        <?php selected( $value, popmake_get_popup_remote_content( $post->ID, 'type' ) ); ?>
                                        ><?php echo $option;?></option>
                                <?php endforeach ?>
                            </select>
                            <p class="description"><?php _e( 'Choose the type of remote content use.', popmake_rc()->textdomain ); ?></p>
                        </td>
                    </tr>


                    <tr class="remote-content-enabled only-ajax">
                        <th scope="row">
                            <label for="popup_remote_content_function_name"><?php _e( 'Function Name', popmake_rc()->textdomain );?></label>
                        </th>
                        <td>
                            <input type="text" class="regular-text" name="popup_remote_content_function_name" id="popup_remote_content_function_name" placeholder="<?php _e( 'A function that will be called and render results.', popmake_rc()->textdomain ); ?>" value="<?php esc_attr_e( popmake_get_popup_remote_content( $post->ID, 'function_name', '' ) ); ?>"/>
                            <p class="description"><?php _e( 'A function that will be called and render results.', popmake_rc()->textdomain )?></p>
                        </td>
                    </tr>

                    <tr class="remote-content-enabled only-loadselector">
                        <th scope="row">
                            <label for="popup_remote_content_css_selector"><?php _e( 'CSS Selector', popmake_rc()->textdomain );?></label>
                        </th>
                        <td>
                            <input type="text" class="regular-text" name="popup_remote_content_css_selector" id="popup_remote_content_css_selector" placeholder="<?php _e( '#main .content', popmake_rc()->textdomain ); ?>" value="<?php esc_attr_e( popmake_get_popup_remote_content( $post->ID, 'css_selector', '' ) ); ?>"/>
                            <p class="description"><?php _e( 'Enter the CSS id or selector that we will will load from links.', popmake_rc()->textdomain )?></p>
                        </td>
                    </tr>

                    <tr class="remote-content-enabled">
                        <th scope="row">
                            <label for="popup_remote_content_loading_icon"><?php _e( 'Loading Icon', popmake_rc()->textdomain );?></label>
                        </th>
                        <td>
                            <select name="popup_remote_content_loading_icon" id="popup_remote_content_loading_icon">
                                <?php foreach( apply_filters( 'popmake_remote_content_loading_icon_options', array() ) as $option => $value ) : ?>
                                    <option
                                        value="<?php echo $value;?>"
                                        <?php selected( $value, popmake_get_popup_remote_content( $post->ID, 'loading_icon' ) ); ?>
                                        ><?php echo $option;?></option>
                                <?php endforeach ?>
                            </select>
                            <p class="description"><?php _e( 'Choose a loding icon style.', popmake_rc()->textdomain ); ?></p>
                        </td>
                    </tr>


                    <?php do_action( 'popmake_remote_content_meta_box_fields', $post->ID );?>
                </tbody>
            </table>
            </div><?php
        }


    }
}
