<?php

/**
 * Admin Menu Bar Edit Form Menu
 *
 * This tool will grab Gravity Forms as they are generated on the front end and create an Edit Form menu for each one, along with a Settings and Entries menu for easy access.
 *
 * Generously contributed by Brian DiChiara of http://briandichiara.com
 *
 * @since 1.3.0
 *
 * @author  Brian DiChiara <briandichiara@gmail.com>
 * @link    http://briandichiara.com
 *
 */
class GFPGFU_AdminMenuBar {

	const TOOL_VERSION = '0.0.3';

	public function __construct() {

		add_action( 'admin_bar_init', array( $this, 'enqueue_script' ) );

		add_action( 'wp_ajax_gfpgfu_adminmenubar_get_title', array( $this, 'get_title' ) );
		add_action( 'wp_ajax_nopriv_gfpgfu_adminmenubar_get_title', array( $this, 'get_title' ) );

	}

	public function enqueue_script() {

		wp_register_script( 'gfpgfu-adminmenubar', GFP_GF_UTILITY_URL . 'tools/admin-menu-bar/js/gfpgfu-admin-menu-bar.min.js', array(
			'admin-bar',
			'jquery'
		), self::TOOL_VERSION );

		wp_localize_script( 'gfpgfu-adminmenubar', 'gfpgfu_adminmenubar_vars', array(
			'schema'   => json_encode( $this->get_gravityforms_schema(), JSON_FORCE_OBJECT ),
			'ajax_url' => admin_url() . 'admin-ajax.php'
		) );

		wp_enqueue_script( 'gfpgfu-adminmenubar' );

	}

	public function get_gravityforms_schema() {

		$schema = array(
			'edit'     => array(
				'url'   => admin_url( 'admin.php?page=gf_edit_forms&id={0}'),
				'label' => 'Edit Form'
			),
			'settings' => array(
				'url'   => admin_url('admin.php?page=gf_edit_forms&view=settings&id={0}'),
				'label' => 'Form Settings'
			),
			'entries'  => array(
				'url'   => admin_url('admin.php?page=gf_entries&id={0}'),
				'label' => 'Form Entries'
			)
		);

		return $schema;

	}

	public function get_title() {

		$response = array();

		$form_id = isset( $_GET[ 'form_id' ] ) ? sanitize_text_field( $_GET[ 'form_id' ] ) : '';

		if ( ! $form_id ) {

			wp_send_json( $response );

		}

		$form_title = $this->lookup_gravityform_title( $form_id );

		if ( $form_title ) {

			$response[ 'form_title' ] = $form_title;

		}

		wp_send_json( $response );
	}

	public function lookup_gravityform_title( $form_id = false ) {

		if ( ! class_exists( 'GFAPI' ) ) {

			return false;

		}

		$form = GFAPI::get_form( $form_id );

		if ( isset( $form[ 'title' ] ) && $form[ 'title' ] ) {

			return $form[ 'title' ];

		}

		return false;
	}

}

$gfpgfu_adminmenubar = new GFPGFU_AdminMenuBar();