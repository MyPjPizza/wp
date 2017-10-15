<?php


/**
 * Show the pages that a form is on, with a link to edit or view the page
 *
 * @since 2.1.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFPGFU_Show_Page_On_Toolbar {

	/**
	 * Pages that have a Gravity Forms shortcode
	 *
	 * @since 2.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var array
	 */
	private $pages = array();

	/**
	 * @since 2.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function run () {

		if ( (in_array( GFForms::get_page(), array( 'form_editor', 'form_settings', 'confirmation', 'notification_edit', 'notification_list', 'entry_list', 'entry_detail') ) ) ||  ('gf_edit_forms' == rgget( 'page' ) && 'settings' == rgget( 'view' ) ) ) {

			add_filter( 'gfp_gf_utility_menu', array( $this, 'gfp_gf_utility_menu' ), 10, 2 );

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

		$this->pages = GFPGFU_Helper::get_pages();

		$next_page_id = 12;

		foreach( $this->pages as $page ) {

			if ( $form_id == $page['form_id'] ) {

				$tools["{$next_page_id}"] = array( 'name'  => 'show-page[]',
				                      'label' => __( 'Page: ', 'gfp-utility' ) . $page['name'],
				                      'url'   => $page['view_url']
				);

				$next_page_id++;

			}

		}

		return $tools;

	}

}

$gfpgfu_show_page_on_toolbar = new GFPGFU_Show_Page_On_Toolbar();

$gfpgfu_show_page_on_toolbar->run();