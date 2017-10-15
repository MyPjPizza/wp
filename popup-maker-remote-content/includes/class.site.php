<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PopMake_Remote_Content_Site' ) ) {

    /**
     * Main PopMake_Remote_Content_Site class
     *
     * @since       1.0.0
     */
    class PopMake_Remote_Content_Site {

	    public function __construct() {
		    add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		    add_filter( 'popmake_get_the_popup_classes', array( $this, 'popup_classes' ), 5, 2 );
		    add_filter( 'popmake_get_the_popup_data_attr', array( $this, 'popup_data_attr' ), 0, 2 );
		    add_filter( 'popmake_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10, 2 );
		    add_filter( 'popmake_enqueue_styles', array( $this, 'enqueue_styles' ), 10, 2 );
	    }
	    
		public function popup_data_attr( $data_attr, $popup_id ) {
			if( popmake_get_popup_remote_content( $popup_id, 'enabled' ) ) {
				$data_attr['meta']['remote_content'] = popmake_get_popup_remote_content( $popup_id );
			}
			return $data_attr;
		}

		public function popup_classes( $classes, $popup_id ) {
			if( popmake_get_popup_remote_content( $popup_id, 'enabled' ) ) {
				$classes[] = 'remote-content';
			}
			return $classes;
		}

		/**
		 * Load frontend scripts
		 *
		 * @since       1.0.0
		 * @return      void
		 */
		public function scripts() {
			// Use minified libraries if SCRIPT_DEBUG is turned off
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			wp_register_script( 'popmake-remote-content-js', POPMAKE_REMOTECONTENT_URL . 'assets/js/scripts' . $suffix . '.js?defer', array( 'popup-maker-site' ), POPMAKE_REMOTECONTENT_VER, true );
			wp_register_style( 'popmake-remote-content-css', POPMAKE_REMOTECONTENT_URL . 'assets/css/styles' . $suffix . '.css', NULL, POPMAKE_REMOTECONTENT_VER );
		}

	    public function enqueue_scripts( $scripts = array(), $popup_id = NULL ) {
		    if( ! is_null( $popup_id ) && popmake_get_popup_remote_content( $popup_id, 'enabled' ) ) {
			    $scripts['remote-content'] = 'popmake-remote-content-js';
		    }
		    return $scripts;
	    }

	    public function enqueue_styles( $styles = array(), $popup_id = NULL ) {
		    if( ! is_null( $popup_id ) && popmake_get_popup_remote_content( $popup_id, 'enabled' ) ) {
			    $styles['remote-content'] = 'popmake-remote-content-css';
		    }
		    return $styles;
	    }

    }
} // End if class_exists check
