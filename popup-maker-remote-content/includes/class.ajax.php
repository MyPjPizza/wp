<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PopMake_Remote_Content_Ajax' ) ) {

    /**
     * Main PopMake_Remote_Content_Ajax class
     *
     * @since       1.0.0
     */
    class PopMake_Remote_Content_Ajax {

	    public function __construct() {
		    add_action( 'wp_ajax_popmake_rc', array( $this, 'process_ajax' ) );
		    add_action( 'wp_ajax_nopriv_popmake_rc', array( $this, 'process_ajax' ) );
	    }

	    function process_ajax() {
			if ( empty( $_REQUEST['popup_id'] ) || $_REQUEST['popup_id'] <= 0 ) {
				die;
			}

		    $popup_id = intval( $_REQUEST['popup_id'] );

		    $settings = popmake_get_popup_remote_content( $popup_id );

		    if ( ! $settings || ! $settings['enabled'] || $settings['type'] != 'ajax' || $settings['function_name'] == '' ) {
			    die;
		    }

		    $response = array();

		    ob_start();

		    call_user_func( $settings['function_name'] );

		    $response['content'] = ob_get_clean();

		    echo json_encode( $response );
		    die();
	    }

    }
} // End if class_exists check
