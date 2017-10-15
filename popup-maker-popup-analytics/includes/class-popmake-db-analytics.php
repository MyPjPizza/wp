<?php
/**
 * Analytics DB class
 *
 * This class is for interacting with the analytics' database table
 *
 * @package     POPMAKE
 * @subpackage  Classes/DB Analytics
 * @copyright   Copyright (c) 2012, Daniel Iser
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * POPMAKE_DB_Analytics Class
 *
 * @since 2.0
 */
class POPMAKE_DB_Analytics extends POPMAKE_DB  {

	/**
	 * Get things started
	 *
	 * @access  public
	 * @since   2.0
	*/
	public function __construct() {

		global $wpdb;

		$this->table_name  = $wpdb->prefix . 'popup_analytics';
		$this->primary_key = 'id';
		$this->version     = '1.0';

	}

	/**
	 * Get columns and formats
	 *
	 * @access  public
	 * @since   2.0
	*/
	public function get_columns() {
		return array(
			'id'            => '%d',
			'popup_id'      => '%d',
			'event_type'    => '%s',
			'session_id'    => '%s',
			'user_id'       => '%d',
			'trigger'       => '%s',
			'open_event_id' => '%d',
			'url'           => '%s',
			'post_id'       => '%d',
			'date_created'  => '%s',
		);
	}

	/**
	 * Get default column values
	 *
	 * @access  public
	 * @since   2.0
	*/
	public function get_column_defaults() {
		return array(
			'popup_id'      => 0,
			'user_id'       => 0,
			'post_id'       => 0,
			'open_event_id' => 0,
			'event_type'    => '',
			'session_id'    => '',
			'trigger'       => '',
			'url'           => '',
			'date_created'  => current_time( 'mysql', 0 ),
		);
	}


	public function get_popup_page_counts( $popup_id, $args = array() ) {
		global $wpdb;

		$args = apply_filters( 'popmake_pa_table_args', $args, 'get_page_counts' );

		$query = $this->prepare_query(
			"SELECT url, SUM( event_type = 'open' ) AS opens, SUM( event_type = 'conversion' ) AS conversions, ( ( SUM( event_type = 'conversion' ) / SUM( event_type = 'open' ) ) *100 ) AS conversion_rate FROM $this->table_name WHERE popup_id = '$popup_id' GROUP BY url",
			$args
		);

		return $wpdb->get_results( $query, 'OBJECT' );
	}

	public function get_popup_period_counts( $popup_id, $args = array() ) {
		global $wpdb;

		$select = "SELECT date_created as date, MONTH(date_created) as month, DAY(date_created) as day, YEAR(date_created) as year";

		if( isset( $args['type'] ) ) {
			switch( $args['type'] ) {
				case "open":
				case "conversion":
					$select .= ", SUM(event_type = '{$args['type']}') as {$args['type']}s";
					break;
				case "conversion_rate":
					$select .= ", ( ( SUM(event_type = 'conversion') / SUM( event_type = 'open' ) ) *100 ) AS conversion_rate";
					break;
			}
		}
		else {
			$select .= ", SUM(event_type = 'open') AS opens, SUM(event_type = 'conversion') AS conversions, ( ( SUM(event_type = 'conversion') / SUM( event_type = 'open' ) ) *100 ) AS conversion_rate";
		}

		$where = "WHERE popup_id = $popup_id";

		$group_by = "GROUP BY " . ( isset( $args['groupby'] ) ? $args['groupby'] : 'day' );

		$query = "$select FROM $this->table_name $where $group_by";

		return $wpdb->get_results( $query, 'OBJECT' );
	}


	/**
	 * Create the table
	 *
	 * @access  public
	 * @since   2.0
	*/
	public function create_table() {

		global $wpdb;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$sql = "CREATE TABLE " . $this->table_name . " (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `popup_id` bigint(20) NOT NULL,
		  `user_id` bigint(20) NOT NULL,
		  `post_id` bigint(20) NOT NULL,
		  `open_event_id` bigint(20) NOT NULL,
		  `event_type` varchar(50) NOT NULL,
		  `session_id` varchar(255) NOT NULL,
		  `trigger` varchar(255) NOT NULL,
		  `url` varchar(255) NOT NULL,
		  `date_created` datetime NOT NULL,
		  PRIMARY KEY (id)
		) CHARACTER
		SET utf8 COLLATE utf8_general_ci";

		dbDelta( $sql );

		update_option( $this->table_name . '_db_version', $this->version );
	}
}