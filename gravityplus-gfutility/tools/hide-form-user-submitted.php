<?php

/**
 * Do not show form if the user has already submitted it
 *
 * @since 1.3.0
 * 
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFPGFU_Hide_Form_User_Submitted {

	/**
	 * GFPGFU_Hide_Form_User_Submitted constructor.
	 */
	public function __construct() {

		$this->add_form_setting();

		$this->add_form_check();

	}

	/**
	 * Add form setting
	 * 
	 * @since
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function add_form_setting() {

		if ( is_admin() && ( 'settings' == rgget( 'view' ) ) ) {

			add_filter( 'gform_form_settings', array( $this, 'gform_form_settings' ), 10, 2 );
			add_filter( 'gform_pre_form_settings_save', array( $this, 'gform_pre_form_settings_save' ) );

		}

	}

	/**
	 * Add form check
	 * 
	 * @since
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function add_form_check() {

		add_filter( 'gform_get_form_filter', array( $this, 'gform_get_form_filter' ), 10, 2 );

	}

	/**
	 * Add setting to form settings
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
	public function gform_form_settings( $settings, $form ) {

		ob_start();

		include( GFP_GF_UTILITY_PATH . '/tools/hide-form-user-submitted/gform-form-settings.php' );

		$settings[ __( 'Restrictions', 'gravityplus-gfutility' ) ][ 'hide_form_user_submitted' ] = ob_get_contents();

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
	function gform_pre_form_settings_save( $form ) {

		$form[ 'hideFormUserSubmitted' ] = rgpost( 'form_hide_form_user_submitted' );


		return $form;

	}

	/**
	 * Determine whether to render the form, or not
	 * 
	 * @since 
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 * 
	 * @param array $form
	 *
	 * @return array|null
	 */
	public function gform_pre_render( $form ) {

		return $this->hide_form_if_user_already_submitted( $form );

	}

	/**
	 * Empty the form 
	 * 
	 * @since 
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 * 
	 * @param string $form_string
	 * @param array  $form
	 *
	 * @return array|null
	 */
	public function gform_get_form_filter( $form_string, $form ) {

		if ( ! rgempty( 'hideFormUserSubmitted', $form ) ) {

			if ( is_null( $this->hide_form_if_user_already_submitted( $form ) ) ) {

				$form_string = '';

			}

		}


		return $form_string;

	}

	/**
	 * Find out if user already has an entry for this form. If so, make the form null.
	 * 
	 * @since
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 * 
	 * @param array $form
	 *
	 * @return array|null
	 */
	private function hide_form_if_user_already_submitted( $form ) {

		if ( is_user_logged_in() ) {

			$search_criteria[ 'field_filters' ][ ] = array( 'key' => 'created_by', 'value' => get_current_user_id() );

			$user_entries = GFAPI::count_entries( $form[ 'id' ], $search_criteria );

			if ( 0 < $user_entries ) {

				$form = null;

			}

		}

		return $form;
	}

}

$gfpgfu_hide_form_user_submitted = new GFPGFU_Hide_Form_User_Submitted();