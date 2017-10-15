<?php
/**
 * Plugin Name: GP Disable Entry Creation
 * Description: Disable entry creation per form with Gravity Forms.
 * Plugin URI: http://gravitywiz.com/
 * Version: 1.0.2
 * Author: Richard Waw, David Smith
 * Author URI: http://gravitywiz.com/
 * License: GPL2
 * Perk: True
 */

/**
 * Saftey net for individual perks that are active when core Gravity Perks plugin is inactive.
 */
$gw_perk_file = __FILE__;
if( ! require_once( dirname( $gw_perk_file ) . '/safetynet.php' ) ) {
    return;
}

class GP_Disable_Entry_Creation extends GWPerk {

    public $version = '1.0.2';
    public $min_gravity_forms_version = '1.8';

    public function init() {

        $this->add_tooltip( $this->key( 'disable_entry_creation' ), sprintf(
            '<h6>%s</h6> %s',
            __( 'Disable entry creation', 'gravityperks' ),
            __( 'An entry must be created for Gravity Forms to function correctly; however, this option will automatically delete
                the entry and any associated files after the submission process has been completed. If the form has a User Registration
                feed, the entry will be deleted once the user has been activated or updated.', 'gravityperks' )
        ) );

        // # UI

        add_filter( 'gform_form_settings',          array( $this, 'add_delete_setting' ), 10, 2 );
        add_action( 'gform_pre_form_settings_save', array( $this, 'save_delete_setting' ), 10 );

        // # Functionality

        add_action( 'gform_after_submission', array( $this, 'maybe_delete_form_entry' ), 15, 2 );
        add_action( 'gform_activate_user',    array( $this, 'delete_form_entry_after_activation' ), 15, 3 );
        add_action( 'gform_user_updated',     array( $this, 'delete_form_entry_after_update' ), 15, 3 );

    }


    // Settings

    function add_delete_setting( $settings, $form ) {
        $is_enabled = ( rgar( $form, 'deleteEntry' ) ) ? 'checked="checked"' : "";
        $settings['Form Options']['deleteEntry'] = '
            <tr>
                <th>' . __( 'Entry creation', 'gravityforms' ) . ' ' . gform_tooltip( $this->key( 'disable_entry_creation' ), '', true ) . '</th>
                <td>
                    <input type="checkbox" id="delete_entry" name="delete_entry" value="1" ' . $is_enabled . ' />
                    <label for="delete_entry">' . __( 'Disable entry creation', 'gravityperks' ) . '</label>
                </td>
            </tr>';
        return $settings;
    }

    function save_delete_setting( $form ) {
        $form['deleteEntry'] = rgpost( 'delete_entry' );
        return $form;
    }



    // Functionality

    function maybe_delete_form_entry( $entry, $form ) {
        $config = is_callable( array( 'GFUser', 'get_active_config' ) ) ? GFUser::get_active_config( $form, $entry ) : array();
        if ( ! rgar( $config, 'is_active' ) ) {
            $this->delete_form_entry( $entry );
        }
    }

    function delete_form_entry_after_activation( $user_id, $user_data, $signup_meta ) {
        $entry = GFAPI::get_entry( $signup_meta['lead_id'] );
        $this->delete_form_entry( $entry );
    }

    function delete_form_entry_after_update( $user_id, $config, $entry ) {
        $this->delete_form_entry( $entry );
    }

    function delete_form_entry( $entry ) {
        $form = GFAPI::get_form( $entry['form_id'] );
        if ( rgar( $form, 'deleteEntry' ) ) {
            $delete = GFAPI::delete_entry( $entry['id'] );
            $result = ( $delete ) ? "entry {$entry['id']} successfully deleted." : $delete;
            GFCommon::log_debug( "GP Disable Entry Creation - GFAPI::delete_entry() - form #{$form['id']}: " . print_r( $result, true ) );
        }
    }



    // Documentation

    public function documentation() {
        return array(
            'type'  => 'url',
            'value' => 'http://gravitywiz.com/documentation/gravity-forms-disable-entry-creation-gp/'
        );
    }

}