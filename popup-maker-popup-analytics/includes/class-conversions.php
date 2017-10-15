<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'PopMake_Popup_Analytics_Conversions' ) ) {

    /**
     * Main PopMake_Popup_Analytics_Conversions class
     *
     * @since       1.0.0
     */
    class PopMake_Popup_Analytics_Conversions {


		public function wpcf7( $cfdata ) {
			if( isset( $_REQUEST['_popmake_pa_conversion_check'] ) ) {
				$popup_id	= $_REQUEST['_popmake_pa_conversion_check'];
				$args		= array(
					'url'           => $_SERVER['HTTP_REFERER'],
					'trigger'       => 'Contact Form 7 ID-' . $cfdata->id() . ': ' . $cfdata->title(),
					'open_event_id' => ! empty( $_REQUEST['_popmake_pa_open_event_id'] ) ? $_REQUEST['_popmake_pa_open_event_id'] : null,
				);
				$event_id	= popmake_pa_popup_analytic_event( 'conversion', $popup_id, $args );
			}
		}

		public function ninja_forms() {
			global $ninja_forms_processing;
			//Get all the user submitted values
			$all_fields = $ninja_forms_processing->get_all_extras();
			if( isset( $all_fields['_popmake_pa_conversion_check'] ) ) {
				$popup_id	= $all_fields['_popmake_pa_conversion_check'];
				$args		= array(
					'url'           => $_SERVER['HTTP_REFERER'],
					'trigger'       => 'Gravity Form ID-' . $ninja_forms_processing->get_form_ID() . ': ' . $ninja_forms_processing->get_form_setting( 'form_title' ),
					'open_event_id' => ! empty( $_REQUEST['_popmake_pa_open_event_id'] ) ? $_REQUEST['_popmake_pa_open_event_id'] : null,
				);
				$event_id	= popmake_pa_popup_analytic_event( 'conversion', $popup_id, $args );
			}

		}
		
		public function gform( $entry, $form ) {
			if( isset( $_REQUEST['_popmake_pa_conversion_check'] ) ) {
				$popup_id	= $_REQUEST['_popmake_pa_conversion_check'];
				$args		= array(
					'url'           => $_SERVER['HTTP_REFERER'],
					'trigger'       => 'Gravity Form ID-' . $form['id'] . ': ' . $form['title'],
					'open_event_id' => ! empty( $_REQUEST['_popmake_pa_open_event_id'] ) ? $_REQUEST['_popmake_pa_open_event_id'] : null,
				);
				$event_id	= popmake_pa_popup_analytic_event( 'conversion', $popup_id, $args );
			}
		}



    }
} // End if class_exists check
