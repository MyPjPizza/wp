<?php

/**
 * Redact field entry information
 *
 * Supports html, text, website, phone, number, date, time, textarea, select, multiselect, checkbox, radio, name, address,
 * email, post_title, post_content, post_category, post_tags, post_excerpt, post_image, post_custom_field, list
 *
 * The value will be available (through the $gfpgfu_redact->redacted_fields array) for any functions that need to take place during the form processing after the entry is saved
 *
 * Generously sponsored by Joseph Sellers of woodworkingmasterclasses.com
 *
 * @since
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFPGFU_Redact {

	/**
	 * Holds all of the redacted field values for use after the value was redacted, like in notifications
	 *
	 * Looks just like the entry array, in that the key is the field ID and the value is the field value
	 *
	 * @since 1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var array
	 */
	public $redacted_fields = array();

	/**
	 * GFPGFU_Redact constructor.
	 */
	public function __construct() {

		$this->add_field_option();

		$this->redact();

		$this->get_redacted_value_after_redact();

	}

	/**
	 * Add redacted field option to form fields
	 * 
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function add_field_option() {

		if ( is_admin() && 'gf_edit_forms' == GFForms::get( 'page' ) ) {

			add_action( 'gform_field_advanced_settings', array( $this, 'gform_field_advanced_settings' ), 10, 2 );
			add_filter( 'gform_tooltips', array( $this, 'gform_tooltips' ) );
			add_action( 'gform_editor_js', array( $this, 'gform_editor_js' ) );
			add_filter( 'gform_noconflict_scripts', array( $this, 'gform_noconflict_scripts' ) );

		}

	}

	/**
	 * Add redacted field setting to advanced field settings
	 * 
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $position
	 * @param $form_id
	 */
	public function gform_field_advanced_settings( $position, $form_id ) {

		if ( 450 == $position ) {

			require_once( trailingslashit( GFP_GF_UTILITY_PATH ) . 'tools/redact/views/gform-field-advanced-settings-redact.php' );

		}

	}

	/**
	 * Add redacted setting tooltip
	 * 
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $tooltips
	 *
	 * @return array
	 */
	public static function gform_tooltips( $tooltips ) {

		$redact_tooltips = array(
			'form_field_redact' => '<h6>' . __( 'Redact', 'gfp-utility' ) . '</h6>' . __( 'Check this box if you do *not* want the information the user places in this field to be saved to the entry. The information will be unrecoverable, but it will be available to functions that use entry values to perform actions while the form is submitting (like notifications).', 'gfp-utility' ),
		);

		return array_merge( $tooltips, $redact_tooltips );

	}

	/**
	 * Add redacted field setting JS
	 * 
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gform_editor_js() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'gfp_utility_redact', trailingslashit( GFP_GF_UTILITY_URL ) . "tools/redact/js/form-editor-redact-setting{$suffix}.js", array( 'gform_form_editor' ), GFP_GF_UTILITY_CURRENT_VERSION );

	}

	/**
	 * Add redact JS to noconflict scripts
	 * 
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $noconflict_scripts
	 *
	 * @return array
	 */
	public static function gform_noconflict_scripts( $noconflict_scripts ) {

		$noconflict_scripts = array_merge( $noconflict_scripts, array( 'gfp_utility_redact' ) );

		return $noconflict_scripts;

	}

	/**
	 * Redact
	 * 
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function redact() {

		add_filter( 'gform_save_field_value', array( $this, 'gform_save_field_value' ), 100, 5 );

	}

	/**
	 * Remove the field value
	 *
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $value
	 * @param $lead
	 * @param $field
	 * @param $form
	 * @param $input_id
	 *
	 * @return string
	 */
	public function gform_save_field_value( $value, $lead, $field, $form, $input_id ) {

		if ( ! empty( $field[ 'redact' ] ) ) {

			$this->redacted_fields[ $input_id ] = $value;

			$value = '';

		}

		return $value;

	}

	/**
	 * Get redacted value after it's been redacted
	 * 
	 * Only works during the same form submission
	 *
	 * @since 1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function get_redacted_value_after_redact() {

		add_filter( 'gform_get_field_value', array( $this, 'gform_get_field_value' ), 10, 3 );

	}

	/**
	 * Get redacted field value
	 *
	 * @since 1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param          $value
	 * @param array    $entry
	 * @param GF_Field $field
	 *
	 * @return array|string
	 */
	public function gform_get_field_value( $value, $entry, $field ) {

		if ( ! empty( $this->redacted_fields ) && ! empty( $field[ 'redact' ] ) ) {

			$field->id;

			$value = array();

			$inputs = $field->get_entry_inputs();

			if ( is_array( $inputs ) ) {

				//making sure values submitted are sent in the value even if
				//there isn't an input associated with it
				$redacted_field_keys = array_keys( $this->redacted_fields );

				natsort( $redacted_field_keys );

				foreach ( $redacted_field_keys as $input_id ) {

					if ( is_numeric( $input_id ) && absint( $input_id ) == absint( $field->id ) ) {

						$value[ $input_id ] = $this->redacted_fields[ $input_id ];

					}
				}

			} else {

				$value = rgget( $field->id, $this->redacted_fields );

			}

		}

		return $value;

	}

}

$gfpgfu_redact = new GFPGFU_Redact();