<?php
/**
 * Add a Gravity Forms toolbar menu
 *
 * @since 2.1.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFPGFU_Toolbar_Menu {

	/**
	 * @since 2.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct() {

			add_filter( 'gform_toolbar_menu', array( $this, 'gform_toolbar_menu' ), 10, 2 );
		
	}

	/**
	 * @since 2.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $menu_items
	 * @param $form_id
	 *
	 * @return mixed
	 */
	public function gform_toolbar_menu ( $menu_items, $form_id ) {

		$menu_items[ 'utility' ] = array(
			'label'          => __( 'Utility', 'gfp-utility' ),
			'icon'           => '<i class="fa fa-wrench fa-lg"></i>',
			'title'          => __( 'Use a utility tool', 'gfp-utility' ),
			'url'            => 'javascript:void(0);',
			'menu_class'     => 'gf_form_toolbar_settings gf_form_toolbar_utilities',
			'link_class'     => '',
			'sub_menu_items' => $this->get_toolbar_sub_menu_items( $form_id ),
			'capabilities'   => 'gravityforms_edit_forms',
			'priority'       => 699
		);

		return $menu_items;

	}

	/**
	 * @since 2.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $form_id
	 *
	 * @return array
	 */
	private function get_toolbar_sub_menu_items ( $form_id ) {

		$sub_menu_items = array();

		$tools          = $this->get_tools( $form_id );

		foreach ( $tools as $tool ) {

			$sub_menu_items[ ] = array(
				'url'          => $tool[ 'url' ],
				'label'        => $tool[ 'label' ],
				'menu_class'   => "gfp_gfutil_{$tool['name']}_li",
				'link_class'   => "gfp_gfutil_{$tool['name']}_link",
				'capabilities' => array( 'gravityforms_edit_forms' )
			);

		}

		return $sub_menu_items;

	}

	/**
	 * @since 2.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $form_id
	 *
	 * @return array|mixed|void
	 */
	private function get_tools ( $form_id ) {

		$tools = array(
			'10' => array( 'name' => 'available-utilities', 'label' => __( 'Available Utilities:', 'gfp-utility' ), 'url' => 'javascript:void(0);' ),
		);

		$tools = apply_filters( 'gfp_gf_utility_menu', $tools, $form_id );

		if ( 1 == count( $tools ) ) {

			$tools['20'] = array( 'name' => 'no-utilities', 'label' => __( 'None', 'gravityplus-gfutility'), 'url' => 'javascript:void(0);' );

		}

		ksort( $tools, SORT_NUMERIC );

		return $tools;

	}

}

new GFPGFU_Toolbar_Menu();