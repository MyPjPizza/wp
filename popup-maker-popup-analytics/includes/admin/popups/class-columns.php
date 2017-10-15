<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'PopMake_Popup_Analytics_Admin_Popup_Columns' ) ) {

    /**
     * Main PopMake_Popup_Analytics_Admin_Popup_Columns class
     *
     * @since       1.0.0
     */
    class PopMake_Popup_Analytics_Admin_Popup_Columns {

		public function columns( $popup_columns ) {
			$new_columns = array(
				'opens'					=> __( 'Opened', 'popup-maker-popup-analytics' ),
				'avg_time_open'			=> __( 'Avg Time Open', 'popup-maker-popup-analytics' ),
				'conversions'			=> __( 'Conversions', 'popup-maker-popup-analytics' ),
				'avg_conversion_time'	=> __( 'Avg Conversion Time', 'popup-maker-popup-analytics' ),
				'conversion_rate'		=> __( 'Conversion Rate', 'popup-maker-popup-analytics' ),
			);
			return array_slice( $popup_columns, 0, 3, true ) + $new_columns + array_slice( $popup_columns, 3, count( $popup_columns ) - 3, true );
		}

		/**
		 * Render Popup Columns
		 *
		 * @since 1.0
		 * @param string $column_name Column name
		 * @param int $post_id Popup (Post) ID
		 * @return void
		 */
		public function render( $column_name, $post_id ) {
			if ( get_post_type( $post_id ) == 'popup' ) {
				global $popmake_options;

				$post = get_post( $post_id );
				setup_postdata( $post );

				$post_type_object = get_post_type_object( $post->post_type );
				$can_edit_post = current_user_can( $post_type_object->cap->edit_post, $post->ID );

				switch ( $column_name ) {
					case 'opens':
						$open_count = get_post_meta( $post_id, 'popup_analytic_opened_count', true );
						if(!$open_count) {
							$open_count = 0;
						}
						echo '<strong>'. $open_count .'</strong>';
						break;
					case 'avg_time_open':
						$avg_time_open = get_post_meta( $post_id, 'popup_analytic_avg_time_open', true );
						if(!$avg_time_open) {
							$avg_time_open = 'N/A';
						}
						else {
							$avg_time_open = formatMilliseconds( $avg_time_open );
						}
						echo '<strong>'. $avg_time_open .'</strong>';
						break;
					case 'conversions':
						$conversion_count = get_post_meta( $post_id, 'popup_analytic_conversion_count', true );
						if(!$conversion_count) {
							$conversion_count = 0;
						}
						echo '<strong>'. $conversion_count .'</strong>';
						break;
					case 'avg_conversion_time':
						$avg_conversion_time = get_post_meta( $post_id, 'popup_analytic_avg_conversion_time', true );
						if(!$avg_conversion_time) {
							$avg_conversion_time = 'N/A';
						}
						else {
							$avg_conversion_time = formatMilliseconds( $avg_conversion_time );
						}
						echo '<strong>'. $avg_conversion_time .'</strong>';
						break;
					case 'conversion_rate':
						$conversion_rate = get_post_meta( $post_id, 'popup_analytic_conversion_rate', true );
						if(!$conversion_rate) {
							$conversion_rate = 'N/A';
						}
						else {
							$conversion_rate = round( $conversion_rate, 3 ) .'%';
						}
						echo '<strong>'. $conversion_rate .'</strong>';
						break;
				}
			}
		}

		/**
		 * Registers the sortable columns in the list table
		 *
		 * @since 1.0
		 * @param array $columns Array of the columns
		 * @return array $columns Array of sortable columns
		 */
		public function sortables( $columns ) {
			$columns['opens']				= 'opens';
			$columns['avg_time_open']		= 'avg_time_open';
			$columns['conversions']			= 'conversions';
			$columns['avg_conversion_time']	= 'avg_conversion_time';
			$columns['conversion_rate']		= 'conversion_rate';
			return $columns;
		}

		/**
		 * Sorts Columns in the Popups List Table
		 *
		 * @since 1.0
		 * @param array $vars Array of all the sort variables
		 * @return array $vars Array of all the sort variables
		 */
		public function sort( $vars ) {
			// Check if we're viewing the "popup" post type
			if ( isset( $vars['post_type'] ) && 'popup' == $vars['post_type'] ) {
				// Check if 'orderby' is set to "name"
				if ( isset( $vars['orderby'] ) && 'opens' == $vars['orderby'] ) {
					$vars = array_merge(
						$vars,
						array(
							'meta_key' => 'popup_analytic_opened_count',
							'orderby'  => 'meta_value_num',
						)
					);
				}
				if ( isset( $vars['orderby'] ) && 'avg_time_open' == $vars['orderby'] ) {
					$vars = array_merge(
						$vars,
						array(
							'meta_key' => 'popup_analytic_avg_time_open',
							'orderby'  => 'meta_value_num',
						)
					);
				}
				if ( isset( $vars['orderby'] ) && 'conversions' == $vars['orderby'] ) {
					$vars = array_merge(
						$vars,
						array(
							'meta_key' => 'popup_analytic_conversion_count',
							'orderby'  => 'meta_value_num',
						)
					);
				}
				if ( isset( $vars['orderby'] ) && 'avg_conversion_time' == $vars['orderby'] ) {
					$vars = array_merge(
						$vars,
						array(
							'meta_key' => 'popup_analytic_avg_conversion_time',
							'orderby'  => 'meta_value_num',
						)
					);
				}
				if ( isset( $vars['orderby'] ) && 'conversion_rate' == $vars['orderby'] ) {
					$vars = array_merge(
						$vars,
						array(
							'meta_key' => 'popup_analytic_conversion_rate',
							'orderby'  => 'meta_value_num',
						)
					);
				}
			}

			return $vars;
		}

		public function load() {
			add_filter( 'request', array( $this, 'sort' ) );
		}

    }
} // End if class_exists check