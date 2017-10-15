<?php
/**
 * You can't actually prevent the entry from being created and do anything useful with the form data, but 
 * we *can* delete it after all of the form submission actions have run
 * 
 * @since
 * 
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFPGFU_Prevent_Entry_Creation {

	/**
	 * GFPGFU_Prevent_Entry_Creation constructor.
	 */
	public function __construct () {

		$this->add_form_options();

		$this->prevent_entry_creation();

	}

	/**
	 * Add form options
	 * 
	 * @since
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function add_form_options () {

		if ( is_admin() && ( 'settings' == rgget( 'view' ) ) ) {

			add_filter( 'gform_form_settings', array( $this, 'gform_form_settings' ), 10, 2 );
			add_filter( 'gform_pre_form_settings_save', array( $this, 'gform_pre_form_settings_save' ) );
		}

	}

	/**
	 * Prevent entry creation
	 * 
	 * @since
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function prevent_entry_creation() {

		add_action( 'gform_after_submission', array( $this, 'gform_after_submission' ), 100, 2 );

	}

	/**
	 * Output form setting
	 * 
	 * @since
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 * 
	 * @param $settings
	 * @param $form
	 *
	 * @return mixed
	 */
	public function gform_form_settings ( $settings, $form ) {

		ob_start();

		include( GFP_GF_UTILITY_PATH . '/tools/prevent-entry-creation/gform-form-settings.php' );

		$settings['Form Options']['prevent_entry_creation'] = ob_get_contents();

		ob_end_clean();


		return $settings;

	}

	/**
	 * Save form setting
	 * 
	 * @since
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 * 
	 * @param $form
	 *
	 * @return mixed
	 */
	function gform_pre_form_settings_save ( $form ) {

		$form['preventEntryCreation']                  = rgpost( 'form_prevent_entry_creation' );

		return $form;

	}

	/**
	 * Delete entry
	 * 
	 * @since 
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 * 
	 * @param $entry
	 * @param $form
	 */
	public function gform_after_submission( $entry, $form ) {

		if ( ! rgempty( 'preventEntryCreation', $form ) ) {

			GFAPI::delete_entry( $entry['id'] );

		}

	}

}

$gfpgfu_prevent_entry = new GFPGFU_Prevent_Entry_Creation();