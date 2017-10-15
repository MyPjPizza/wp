<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;


class PopMake_Remote_Content_Admin {

	public $metaboxes;

	public function __construct() {
		$this->metabox = new PopMake_Remote_Content_Admin_Popup_Metaboxes();
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ), 100 );
	}

	public function install_check() {
		$version = get_option( 'popmake_remote_content_version' );
		update_option( 'popmake_remote_content_version', POPMAKE_REMOTECONTENT_VER );
	}


	/**
	 * Load frontend scripts
	 *
	 * @since       1.0.0
	 * @return      void
	 */
	public function scripts( $hook ) {
		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		if( popmake_is_admin_page() ) {
			wp_enqueue_script( 'popmake-remote-content-admin-js', POPMAKE_REMOTECONTENT_URL . 'assets/js/admin' . $suffix . '.js', array( 'jquery', 'popup-maker-admin' ), POPMAKE_REMOTECONTENT_VER );
		}
	}

}
