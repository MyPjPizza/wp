<?php

function popmake_pa_popup_analytic_event( $type, $popup_id, $args = array() ) {

	if( popmake_get_option( 'popmake_pa_logged_in_tracking_disabled', false ) && count( popmake_get_option( 'popmake_pa_logged_in_tracking_level' ) ) ) {
		foreach( popmake_get_option( 'popmake_pa_logged_in_tracking_level', array() ) as $role => $label ) {
			if( current_user_can( $role ) ) {
				return 0;
			}
		}
	}

	if( $type != 'open' ) {
		if( empty( $args['open_event_id'] ) ) {
			return 0;
		}

		$open_event = PopMake_Popup_Analytics()->db->get( $args['open_event_id'] );

		if( is_null( $open_event ) || $open_event->session_id != session_id() ) {
			return 0;
		}
	}

	$event_id = PopMake_Popup_Analytics()->db->insert( array(
		'popup_id'      => $popup_id,
		'user_id'       => get_current_user_id(),
		'post_id'       => url_to_postid( $args['url'] ),
		'open_event_id' => $args['open_event_id'],
		'event_type'    => $type,
		'session_id'    => session_id(),
		'trigger'       => strlen( $args['trigger'] ) > 255 ? substr( $args['trigger'], 0, 255 ) : $args['trigger'],
		'url'           => $args['url'],
	) );

	if($type == 'open') {
		popmake_pa_increase_popup_opened_count( $popup_id );
		popmake_pa_update_popup_last_opened( $popup_id );
		popmake_pa_increase_total_opened_count();
		popmake_pa_update_conversion_rate( $popup_id );
	}
	if($type == 'close') {
		popmake_pa_increase_popup_closed_count( $popup_id );
		popmake_pa_update_time_open( $popup_id, $event_id );
		popmake_pa_update_popup_last_closed( $popup_id );
		popmake_pa_increase_total_closed_count();
	}
	if($type == 'conversion') {
		popmake_pa_increase_popup_conversion_count( $popup_id );
		popmake_pa_update_conversion_time( $popup_id, $event_id );
		popmake_pa_update_popup_last_conversion( $popup_id );
		popmake_pa_increase_total_conversion_count();
		popmake_pa_update_conversion_rate( $popup_id );
	}

	if( popmake_get_option( 'popmake_pa_ga_enabled', false ) && popmake_get_option( 'popmake_pa_ga_tid', '' ) != '' ) {

		$event = false;
		if(get_post_meta( $popup_id, "popup_analytics_{$type}_event_override", true) != '') {
			$event = array(
				'category' => get_post_meta( $popup_id, "popup_analytics_{$type}_event_category", true),
				'action' => get_post_meta( $popup_id, "popup_analytics_{$type}_event_action", true),
				'label' => get_post_meta( $popup_id, "popup_analytics_{$type}_event_label", true),
				'value' => get_post_meta( $popup_id, "popup_analytics_{$type}_event_value", true),
			);
		}
		else {
			$event = popmake_get_option( "popmake_pa_ga_{$type}_events" );
		}

		if( ! empty( $event['category'] ) && ! empty( $event['action'] ) && ! empty( $event['label'] ) ) {
			foreach( $event as $key => $val ) {
				if( in_array( $val, array( '[open_trigger]', '[close_trigger]', '[conversion_trigger]' ) ) ) {
					$event[ $key ] = $args['trigger'];
				}
			}

			$ga_params = array(
				'v' => 1, // Version.
				'tid' => popmake_get_option( 'popmake_pa_ga_tid' ), // Tracking ID / Property ID.
				'cid' => popmake_ga_parse_cookie(), // Anonymous Client ID.
				't' => 'event', // Event hit type
				'ec' => $event['category'],	// Event Category. Required.
				'ea' => $event['action'], // Event Action. Required.
				'el' => $event['label'], // Event label.
				'ev' => $event['value'], // Event value.
			);

			// Set url if it's not empty.
			if( ! empty( $args['url'] ) ) {
				$ga_params['dl'] = $args['url'];
			}

			// Set it to non interactive unless its a conversion. Wont affect bounce rate.
			if( $type != 'conversion' ) {
				$ga_params['ni'] = 1;
			}

			popmake_pa_ga_fire_hit( $ga_params );
		}

	}


	return $event_id;
}

function popmake_pa_track_popup_open( $popup_id, $args = array() ) {
	return popmake_pa_popup_analytic_event( 'open', $popup_id, $args );
}

function popmake_pa_track_popup_close( $popup_id, $args = array() ) {
	return popmake_pa_popup_analytic_event( 'close', $popup_id, $args );
}

function popmake_pa_track_popup_conversion( $popup_id, $args = array() ) {
	return popmake_pa_popup_analytic_event( 'conversion', $popup_id, $args );
}


/*
	Functions for open events and statistics.
 */
function popmake_pa_increase_popup_opened_count( $popup_id ) {
	$current_total = get_post_meta( $popup_id, 'popup_analytic_opened_count', true );
	if( ! $current_total ) {
		$current_total = 0;
	}
	update_post_meta( $popup_id, 'popup_analytic_opened_count', $current_total + 1 );
}

function popmake_pa_update_popup_last_opened( $popup_id ) {
	update_post_meta( $popup_id, 'popup_analytic_last_opened', current_time( 'timestamp', 0 ) );
}

function popmake_pa_increase_total_opened_count() {
	update_option( 'popup_analytics_total_opened_count', get_option( 'popup_analytics_total_opened_count', 0 ) + 1 );
}


/*
	Functions for close events and statistics.
 */
function popmake_pa_increase_popup_closed_count( $popup_id ) {
	$current_total = get_post_meta( $popup_id, 'popup_analytic_closed_count', true );
	if( ! $current_total ) {
		$current_total = 0;
	}
	update_post_meta( $popup_id, 'popup_analytic_closed_count', $current_total + 1 );
}

function popmake_pa_update_popup_last_closed( $popup_id ) {
	update_post_meta( $popup_id, 'popup_analytic_last_closed', current_time( 'timestamp', 0 ) );
}

function popmake_pa_increase_total_closed_count() {
	update_option( 'popup_analytics_total_closed_count', get_option( 'popup_analytics_total_closed_count', 0 ) + 1 );
}

function popmake_pa_update_time_open( $popup_id, $event_id ) {

	$close_event = PopMake_Popup_Analytics()->db->get( $event_id );

	$open_event = PopMake_Popup_Analytics()->db->get( $close_event->open_event_id );

	$total_time_open	= get_post_meta( $popup_id, 'popup_analytic_total_time_open', true );
	$closed_count		= get_post_meta( $popup_id, 'popup_analytic_closed_count', true );

	if( ! $total_time_open ) {
		$total_time_open = 0;
	}
	if( ! $closed_count ) {
		$closed_count = 0;
	}

	$new_time = ( strtotime( $close_event->date_created ) - strtotime( $open_event->date_created ) ) * 1000;

	// Calculate & Update Total Time Open
	$total_time_open = $total_time_open + $new_time;
	update_post_meta( $popup_id, 'popup_analytic_total_time_open', $total_time_open );

	// Calculate & Update Average
	$new_avg = $total_time_open / $closed_count;
	update_post_meta( $popup_id, 'popup_analytic_avg_time_open', $new_avg );
}



function popmake_pa_increase_popup_conversion_count( $popup_id ) {
	$current_total = get_post_meta( $popup_id, 'popup_analytic_conversion_count', true );
	if( ! $current_total ) {
		$current_total = 0;
	}
	update_post_meta( $popup_id, 'popup_analytic_conversion_count', $current_total + 1 );
}

function popmake_pa_update_popup_last_conversion( $popup_id ) {
	update_post_meta( $popup_id, 'popup_analytic_last_conversion', current_time( 'timestamp', 0 ) );
}

function popmake_pa_increase_total_conversion_count() {
	update_option( 'popup_analytics_total_conversion_count', get_option( 'popup_analytics_total_conversion_count', 0 ) + 1 );
}

function popmake_pa_update_conversion_time( $popup_id, $event_id ) {

	$conversion_event = PopMake_Popup_Analytics()->db->get( $event_id );

	$open_event = PopMake_Popup_Analytics()->db->get( $conversion_event->open_event_id );

	$total_conversion_time = get_post_meta( $popup_id, 'popup_analytic_total_conversion_time', true );
	$conversion_count      = get_post_meta( $popup_id, 'popup_analytic_conversion_count', true );

	if( ! $total_conversion_time ) {
		$total_conversion_time = 0;
	}
	if( ! $conversion_count ) {
		$conversion_count = 0;
	}
	
	$new_time = ( strtotime( $conversion_event->date_created ) - strtotime( $open_event->date_created ) ) * 1000;

	// Calculate & Update Total Conversion Time
	$total_conversion_time = $total_conversion_time + $new_time;
	update_post_meta( $popup_id, 'popup_analytic_total_conversion_time', $total_conversion_time );

	// Calculate & Update Average
	$new_avg = $total_conversion_time / $conversion_count;
	update_post_meta( $popup_id, 'popup_analytic_avg_conversion_time', $new_avg );
}


function popmake_pa_update_conversion_rate( $popup_id ) {
	$opened_count		= get_post_meta( $popup_id, 'popup_analytic_opened_count', true );
	$conversion_count	= get_post_meta( $popup_id, 'popup_analytic_conversion_count', true );
	if( ! $opened_count ) {
		$opened_count = 0;
	}
	if( ! $conversion_count ) {
		$conversion_count = 0;
	}
	$conversion_rate = $conversion_count / $opened_count * 100;
	update_post_meta( $popup_id, 'popup_analytic_conversion_rate', $conversion_rate );
}


function popmake_pa_reset_tracking_data( $popup_id ) {
	PopMake_Popup_Analytics()->db->delete_by( 'popup_id', $popup_id );
	$post_meta_keys = array(
		'popup_analytic_opened_count',
		'popup_analytic_last_opened',
		'popup_analytic_closed_count',
		'popup_analytic_total_time_open',
		'popup_analytic_avg_time_open',
		'popup_analytic_conversion_count',
		'popup_analytic_last_conversion',
		'popup_analytic_total_conversion_time',
		'popup_analytic_avg_conversion_time',
		'popup_analytic_conversion_rate',
	);
	foreach( $post_meta_keys as $key ) {
		delete_post_meta( $popup_id, $key );
	}
}
