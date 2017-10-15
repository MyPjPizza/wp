<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'PopMake_Popup_Analytics_Legacy' ) ) {

    /**
     * Main PopMake_Popup_Analytics_Legacy class
     *
     * @since       1.0.0
     */
    class PopMake_Popup_Analytics_Legacy {

    	public function __construct() {
    		add_action( 'init', array( $this, 'setup_post_types' ), 1 );
			add_filter( 'popmake_default_post_type_name', array( $this, 'default_post_type_name' ) );
    	}

		/**
		 * Get Default Labels
		 *
		 * @since 1.0
		 * @return array $defaults Default labels
		 */
		public function default_post_type_name( $defaults ) {
			return array_merge( $defaults, array(
				'popup_analytic_event' => array(
					'singular' => __( 'Analytic', 'popup-maker-popup-analytics' ),
					'plural' => __( 'Analytics', 'popup-maker-popup-analytics' )
				),
			));
		}


		public function setup_post_types() {
			global $popup_analytic_event_post_type;

			$popup_analytic_event_labels = apply_filters( 'popmake_popup_analytic_event_labels', array(
				'name'					=> '%2$s',
				'singular_name'			=> '%1$s',
				'menu_name'				=> __( 'Analytics', 'popup-maker-popup-analytics' )
			) );

			foreach ( $popup_analytic_event_labels as $key => $value ) {
				$popup_analytic_event_labels[ $key ] = sprintf( $value, popmake_get_label_singular( 'popup_analytic_event' ), popmake_get_label_plural( 'popup_analytic_event' ) );
			}

			$popup_analytic_event_args = array(
				'labels' 			=> $popup_analytic_event_labels,
				'public'             => false,
				'rewrite'            => false,
				'capability_type'    => 'post',
				'query_var' 		=> false,
				'supports' 			=> apply_filters( 'popmake_popup_analytic_event_supports', array( 'title', 'editor' ) ),
			);
			$popup_analytic_event_post_type = register_post_type( 'popup_analytic_event', apply_filters( 'popmake_popup_analytic_event_post_type_args', $popup_analytic_event_args ) );
		}


    }
} // End if class_exists check
