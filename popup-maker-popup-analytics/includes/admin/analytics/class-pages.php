<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'PopMake_Popup_Analytics_Admin_Analytics_Pages' ) ) {

	/**
     * Main PopMake_Popup_Analytics_Admin_Analytics_Pages class
     *
     * @since       1.1.0
     */
	class PopMake_Popup_Analytics_Admin_Analytics_Pages {

		public function get_report( $report_name ) {
			$report = 'report_' . $report_name;
			if( method_exists( $this, $report ) ) {
				$this->$report();
			}
			else {
				?><h3><?php _e( 'Report not found', 'popup-maker-popup-analytics' ); ?></h3><?php
			}
		}

		public function report_open_stats() {
			$page_url = $_SERVER['PHP_SELF'];
			$query_args = array();
			parse_str($_SERVER['QUERY_STRING'], $query_args);

			$popup_id = intval( $_GET['popup_id'] ); ?>

			<style>

				.graph-container {
					box-sizing: border-box;
					width: 100%;
					height: 450px;
					padding: 20px 15px 15px 15px;
					margin: 15px auto 30px auto;
					border: 1px solid #ddd;
					background: #fff;
				}

				.graph-placeholder {
					width: 100%;
					height: 100%;
					font-size: 14px;
					line-height: 1.2em;
				}
			</style>


			<div class="graph-container">
				<div id="graph-placeholder" class="graph-placeholder"></div>
			</div><?php

			$totals = PopMake_Popup_Analytics()->db->get_popup_period_counts( $popup_id, array(
				//'type' => 'conversion'
			) );

			$stat_plots = array();
			$intervals = array();

			$i = 0;
			foreach( $totals as $period ) {
				$intervals[] = array( 'int' => $i, 'label' => $period->month .'/'. $period->day . '/' . $period->year );
				if( isset( $period->opens ) ) {
					$stat_plots['opens'][] = $period->opens;
				}
				if( isset( $period->conversions ) ) {
					$stat_plots['conversions'][] = $period->conversions;
				}
				if( isset( $period->conversion_rate ) ) {
					$stat_plots['conversion_rate'][] = $period->conversion_rate;
				}
				$i++;
			}

			$types = array(
				'opens' => array( 'label' => __( 'Opens', 'popup-maker-popup-analytics' ), 'data' => '' ),
				'conversions' => array( 'label' => __( 'Conversions', 'popup-maker-popup-analytics' ), 'data' => '' ),
				'conversion_rate' => array( 'label' => __( 'Conversion Rate', 'popup-maker-popup-analytics' ), 'data' => '' ),
			);
			foreach( $stat_plots as $type => $plots ) { 
				$i = 0;
				$values = '';
				foreach( $plots as $plot ) {
					$values .= "[" . $intervals[$i]['int'] . "," . $plot . "],";
					$i++;
				}
				$types[ $type ]['data'] = trim( $values, ',' );
			}

			$data = '';
			foreach( $types as $type ) {
				if( $type['data'] != '' ) {
					$data .= '{data: [' . $type['data'] . '], label: "' . $type['label'] . '"},';
				}
			}

			$ticks = '';
			foreach( $intervals as $interval ) {
				$ticks .= '[' . $interval['int'] . ',"' . $interval['label'] . '"],';
			}

			?>
			<script type="text/javascript">
				(function($) {
				    $.plot(
				    	"#graph-placeholder",
				    	[ <?php echo trim( $data, ',' ); ?> ],
				    	{
				    		xaxis: {
								ticks: [
									<?php echo $ticks; ?>
								]
				    		},
				    		yaxis: {
				    			tickDecimals: 0
				    		},
	    					series: {
								lines: {
									show: true
								},
								points: {
									show: true
								}
							},
							grid: {
								hoverable: true,
								clickable: true
							}
					    }
				    );
					$("<div id='tooltip'></div>").css({
						position: "absolute",
						display: "none",
						border: "1px solid #fdd",
						padding: "2px",
						"background-color": "#fee",
						opacity: 0.80
					}).appendTo("body");

					$("#graph-placeholder").bind("plothover", function (event, pos, item) {

						if (item) {
							var x = item.datapoint[0].toFixed(2),
								y = item.datapoint[1].toFixed(2);
							$("#tooltip").html(y + " " + item.series.label + " on " + item.series.xaxis.ticks[item.dataIndex].label)
								.css({top: item.pageY+5, left: item.pageX+5})
								.fadeIn(200);
						} else {
							$("#tooltip").hide();
						}
					});
				}(jQuery));
			</script>

			<?php
		}

		public function report_url_stats() {

			$page_url = $_SERVER['PHP_SELF'];
			$query_args = array();
			parse_str($_SERVER['QUERY_STRING'], $query_args);

			$popup_id = intval( $_GET['popup_id'] ); ?>

			<h2><?php _e( 'URL Stats', 'popup-maker-popup-analytics' ); ?></h2><?php

			$page_counts = PopMake_Popup_Analytics()->db->get_popup_page_counts( $popup_id );

			$table_columns = array(
				'url' => array(
					'label' => __( 'URL', 'popup-maker-popup-analytics' ),
					'sortable' => true,
					'default_sort' => 'ASC',
				),
				'opens' => array(
					'label' => __( 'Views', 'popup-maker-popup-analytics' ),
					'sortable' => true,
					'default_sort' => 'DESC',
				),
				'conversions' => array(
					'label' => __( 'Conversions', 'popup-maker-popup-analytics' ),
					'sortable' => true,
					'default_sort' => 'DESC',
				),
				'conversion_rate' => array(
					'label' => __( 'Conversion Rate', 'popup-maker-popup-analytics' ),
					'sortable' => true,
					'default_sort' => 'DESC',
				),
			);

			$table_args = $this->table_args(); ?>

			<table class="views-per-page wp-list-table widefat fixed pages">
				<thead>
					<tr>
						<?php foreach( $table_columns as $column => $details ) :
						$classes = array();

						$url_args = $query_args;

						if( $details['sortable'] ) {

							$classes[] = 'sortable';
							$sorted = $table_args['orderby'] == $column;

							$url_args['orderby'] = $column;

							if( $sorted ) {
								$classes[] = 'sorted';
								$classes[] = strtolower( $table_args['order'] );
								$url_args['order'] = $table_args['order'] == 'DESC' ? 'ASC' : 'DESC';
							}
							else {
								$classes[] = strtolower( $details['default_sort'] );
								$url_args['order'] = $details['default_sort'] == 'DESC' ? 'ASC' : 'DESC';
							}

						}

						$sortlink = $page_url . '?' . http_build_query( $url_args );
						?>

						<th class="manage-column <?php echo implode( ' ', $classes ); ?>">
							<a href="<?php echo esc_url( $sortlink ); ?>">
								<span><?php echo $details['label']; ?></span>
								<?php if( $details['sortable'] ) : ?>
								<span class="sorting-indicator"></span>
								<?php endif; ?>
							</a>
						</th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach( $page_counts as $page_count ) : ?>
					<tr>
						<td><?php echo $page_count->url; ?> <a href="<?php echo $page_count->url; ?>" target="_blank"><?php echo $this->external_link_image(); ?></a></td>
						<td><?php echo $page_count->opens; ?></td>
						<td><?php echo $page_count->conversions; ?></td>
						<td><?php echo round( $page_count->conversion_rate, 3 ) .'%'; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table><?php
    	}

    	public function popup_overview() {

    	}



    	public function render() { ?>

	    	<div class="wrap"><?php

				$page_url = $_SERVER['PHP_SELF'];
				$query_args = array();
				parse_str($_SERVER['QUERY_STRING'], $query_args);

	    		if( ! isset( $_GET['popmake-action'] ) ) {

		    		if( ! empty( $_GET['popup_id'] ) && FALSE !== get_post_status( $_GET['popup_id'] ) && ! empty( $_GET['report'] ) ) {

						$popup_id = intval( $_GET['popup_id'] ); ?>

						<h1><?php _e( 'Popup', 'popup-maker-popup-analytics' ); ?>: <?php echo get_the_title( $popup_id ); ?></h1><?php

	    				$this->report_selction_form();

		    			$this->get_report( $_GET['report'] );

	    			}
		    		else { ?>
	    				<h2><?php _e( 'Select a Popup', 'popup-maker-popup-analytics' ); ?></h2><?php
	    				$this->report_selction_form();
		    		}

		    	}
		    	else { ?>

		    		<h2><?php _e( 'Process Upgrades.', 'popup-maker-popup-analytics' ); ?></h2><?php
		    		switch( $_GET['popmake-action'] ) {
		    			case 'import_posttypes':

		    				if( wp_count_posts( 'popup_analytic_event' )->publish ) {

		    					if( isset( $_GET['start'] ) ) { ?>
			    					<p><?php _e( 'Please wait, this could take several minutes.', 'popup-maker-popup-analytics' ); ?></p><?php

				    				PopMake_Popup_Analytics()->upgrades->import_from_post_type(); ?>
									<script type="text/javascript">
										setTimeout(function() { location.reload(true); }, 250);
									</script><?php
		    					}
		    					else {
		    						$query_args['start'] = 1;
		    						printf( __( 'This could take several minutes. Please be patient. Click %shere%s to start.', 'popup-maker-popup-analytics' ), '<a href="' . $page_url . '?' . http_build_query( $query_args ) . '">', '</a>' );
		    					}



		    				}
		    				else { ?>
		    					<p><?php _e( 'Upgrade Complete.', 'popup-maker-popup-analytics' ); ?></p><?php		    					
		    				}

		    				break;
		    		}
		    	} ?>
    		</div><?php
    	}

    	public function table_args( $args = array(), $query = NULL, $params = array() ) {

    		$args = array_merge( $args, array(
				'orderby' => NULL,
				'order' => NULL,
				'limit' => 10,
				'offset' => NULL,
    		) );

			if( ! empty( $_GET['orderby'] ) ) {
				$args['orderby'] = $_GET['orderby'];
				$args['order'] = isset( $_GET['order'] ) ? $_GET['order'] : 'DESC';
			}

    		if( ! empty( $_GET['paged'] ) ) {
    			$args['limit'] = isset( $_GET['limit'] ) ? intval( $_GET['limit'] ) : 10;
    			$args['offset'] = ( $args['limit'] * intval( $_GET['paged'] ) ) - $args['limit'];
    		}

    		return $args;

    	}

    	public function report_selction_form() {
			$page_url = $_SERVER['PHP_SELF'];
			$query_args = array();
			parse_str($_SERVER['QUERY_STRING'], $query_args);
			$popup_id = isset( $_GET['popup_id'] ) ? intval( $_GET['popup_id'] ) : NULL;
			$report = isset( $_GET['report'] ) ? $_GET['report'] : NULL; ?>

			<form method="get" action="<?php echo $page_url; ?>"><?php
				foreach( $query_args as $input => $value ) : if( $input == 'page' || $input == 'post_type' ) : ?>
				<input type="hidden" name="<?php echo $input; ?>" value="<?php echo $value; ?>" /><?php
				endif; endforeach;

				$popups = get_posts( array( 'post_type' => 'popup', 'posts_per_page' => -1 ) ); ?>
				<select name="popup_id"><?php
				foreach ( $popups as $popup ) : ?>
					<option value="<?php echo $popup->ID; ?>" <?php selected( $popup_id, $popup->ID ); ?>><?php echo $popup->post_title; ?></option><?php
				endforeach;
				wp_reset_postdata(); ?>
				</select><?php

				$reports = array(
					__( 'URL Stats', 'popup-maker-popup-analytics' ) => 'url_stats',
					__( 'Open Stats', 'popup-maker-popup-analytics' ) => 'open_stats',
				); ?>

				<select name="report"><?php
				foreach ( $reports as $label => $value ) : ?>
					<option value="<?php echo $value; ?>" <?php selected( $value, $report ); ?>><?php echo $label; ?></option><?php
				endforeach; ?>
				</select>

				<input type="submit" value="<?php _e( 'Submit' ); ?>"/>
			</form><?php

    	}

    	public function external_link_image() {
    		return '<img style="width:1.1em;line-height:1em;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAABAAAAAQBPJcTWAAAAIXRFWHRUaXRsZQBUV08gSk9JTkVEIFNRVUFSRVMgKFUrMjlDOSnNq82/AAAAFXRFWHRBdXRob3IAQW5kcmV3IE1hcmN1c2XnNzeDAAAAL3RFWHRTb2Z0d2FyZQBpbmZvLmZpbGVmb3JtYXQuZGF0YS5Vbmljb2RlUG5nU2VydmxldGgBfzAAAABCdEVYdERlc2NyaXB0aW9uAGh0dHA6Ly93d3cuZmlsZWZvcm1hdC5pbmZvL2luZm8vdW5pY29kZS8yOWM5L2luZGV4Lmh0bbpurboAAAA7dEVYdENvcHlyaWdodABodHRwOi8vY3JlYXRpdmVjb21tb25zLm9yZy9saWNlbnNlcy9ieS1uYy1zYS8yLjAvbIiSgwAAAOtJREFUeNrt3NEJgCAUQFGHdTAHc5dqgArELH2dC+83g9OHRJaSJEmSJEmSJH3YFmSAAAECBAgQICdTjymTTv0jSJn4fgsQIECAAAECBAgQIECAAAEC5KY8yauT3uvmKCBXT+xqU4AAAQIECBAg725Dn1gPCBAgQIAAAQIECBAgQIAAAQIECBAgQIAAAQIECBAgQIAAAQIEyAiQlmPRo761bV0vNEj0HwcAAQIECBAgIUFm2IauttUHAgQIECBAgAABAgQIECBAgADpBHFOHQgQIECAAFmst/8oN2pykiRJkiRJkiRJkiRJQ9oBX+iM4I18t5QAAAAASUVORK5CYII="/>';
    	}

    }
} // End if class_exists check