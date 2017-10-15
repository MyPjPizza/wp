<?php

/**
 * @since
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFPGFU_Toggle_All_Fields_Required {

	/**
	 * GFPGFU_Toggle_All_Fields_Required constructor.
	 * 
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct () {

		add_action( 'admin_init', array( $this, 'admin_init' ) );

	}

	/**
	 * 
	 */
	public function admin_init () {

		if ( ( 'gf_edit_forms' == GFForms::get( 'page' ) ) && ( '' == rgget( 'view' ) ) && is_numeric( rgget( 'id' ) ) ) {

			add_filter( 'gfp_gf_utility_menu', array( $this, 'gfp_gf_utility_menu' ), 10, 2 );
			
			add_action( 'gform_editor_js', array( $this, 'gform_editor_js' ) );
			
			add_filter( 'gform_noconflict_scripts', array( $this, 'gform_noconflict_scripts' ) );

		}

	}

	/**
	 * @since 2.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $tools
	 * @param $form_id
	 *
	 * @return mixed
	 */
	public function gfp_gf_utility_menu ( $tools, $form_id ) {

		$tools['11'] = array( 'name' => 'toggle-all-fields-required', 'label' => __( 'Toggle All Fields Required', 'gfp-utility' ), 'url' => 'javascript:void(0);' );
		

		return $tools;

	}

	/**
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gform_editor_js () {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		wp_enqueue_script( 'gfp_gfutil_toggle_all_fields_required', trailingslashit( GFP_GF_UTILITY_URL ) . "tools/toggle-all-fields-required/toggle-all-fields-required{$suffix}.js", array( 'jquery' ), GFP_GF_UTILITY_CURRENT_VERSION );

		wp_localize_script( 'gfp_gfutil_toggle_all_fields_required', 'gfp_gfutil_toggle_all_fields_required_vars', array( 'set' => __( 'All fields set as required', 'gfp-utility' ), 'unset' => __( 'All fields unset as required', 'gfp-utility' ) ) );

	}

	/**
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public static function gform_noconflict_scripts ( $noconflict_scripts ) {

		$noconflict_scripts = array_merge( $noconflict_scripts, array( 'gfp_gfutil_toggle_all_fields_required' ) );

		return $noconflict_scripts;

	}

}

$gfpgfu_toggle_all_fields_required = new GFPGFU_Toggle_All_Fields_Required();