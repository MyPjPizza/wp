<?php


	/**
 	 Class Name: SP Gravity Forms Datatables
	 Class URI: http://specialpress.de/plugins/spgfdt
	 Description: Integrate the JS Datatables into your Gravity Forms
	 Version: 1.6.0
	 Date: 2017/02/26
	 Author: Ralf Fuhrmann
	 Author URI: http://naranili.de
	 */

	
	
	class SpGfDataTables
	{

			
		/**
		 * array of all supported fields
		 */
		var $supported_fields = array(
			'text',
			'textarea',
			'select',
			'multiselect',
			'number',
			'checkbox',
			'radio',
			'hidden',
			'name',
			'address',
			'date',
			'time',
			'phone',
			'website',
			'email',
			'list',
			'post_title',
			'post_content',
			'post_excerpt',
			'post_category',
			'post_tags',
			'post_custom_field',
			'product',
			'quantity',
			'option',
			'shipping',
			'total',
			'creditcard'
			);
			

						
		/**
		 * construct
		 */
		function SpGfDataTables() 
		{
			
			
			/**
			 * add actions
			 */
			add_action( 'init', array( &$this, 'spgfdt_init') );
			add_action( 'wp_enqueue_scripts', array( &$this, 'spgfdt_wp_enqueue_scripts' ) );
			add_action( 'wp_ajax_get_gravitylist', array( &$this, 'spgfdt_wp_ajax_get_gravitylist' ) );
			add_action( 'wp_ajax_nopriv_get_gravitylist', array( &$this, 'spgfdt_wp_ajax_get_gravitylist' ) );
	
				
			/**
			 * add shortcodes
			 */
			add_shortcode( 'gravitylist', array( &$this, 'shortcode_gravitylist' ) );

				
			/**
			 * add GF actions
			 */
			add_action( 'gform_field_standard_settings', array( &$this, 'spgfdt_gform_field_standard_settings' ), 10, 2 );				
			add_action( 'gform_editor_js', array( &$this, 'spgfdt_gform_editor_js' ), 10 );
	

			/**
			 * add GF filters
			 */
			add_filter( 'gform_form_settings', array( &$this, 'spgfdt_gform_form_settings' ), 10, 2 );
			add_filter( 'gform_pre_form_settings_save', array( &$this, 'spgfdt_gform_pre_form_settings_save' ), 10, 1 );
	
	
			/**
			 * add internal actions
			 */
			add_action( 'spgfdt_wp_ajax_get_gravitylist_GFAPI', array( &$this, 'spgfdt_wp_ajax_get_gravitylist_GFAPI' ) );
				
				

		}	
			

			
		/**
		 * init the plugin
		 */
		function spgfdt_init() 
		{
			

			/**
			 * load the textdomain
			 */
			if( function_exists( 'load_plugin_textdomain' ) )
				load_plugin_textdomain( 'spgfdt', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
					
					
		}



		/** 
		 * if we have the gravitylist shortcode at the current post
		 * we have to load the datatables JS and CSS
		 */
		function spgfdt_wp_enqueue_scripts()
		{

					
			global $post;
			if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'gravitylist') ) 
			{

				wp_enqueue_script( 'datatable', plugins_url( '/datatables/js/jquery.dataTables.min.js' , __FILE__ ), array( 'jquery' ) );			
				wp_enqueue_style( 'datatable', plugins_url( '/datatables/css/jquery.dataTables.min.css' , __FILE__ ) );			
				add_action( 'wp_footer', array( &$this, 'spgfdt_wp_footer') );
				
			}					
					

		}
			
			
			
		/**
		 * init the datatable
		 */
		function spgfdt_wp_footer()
		{
					
				
			if( $_SESSION[ 'dt_params' ][ 'form_id' ] )
			{
					
				$form = GFAPI::get_form( $_SESSION[ 'dt_params' ][ 'form_id' ] );
							
				if( wp_script_is( 'datatable' ) )
				{
						
						
					$locale = get_locale();
						
					?>
					<script type="text/javascript" class="init">
						jQuery(document).ready(function() {
							jQuery('#gravitylist_<?php echo $_SESSION[ 'dt_params' ][ 'form_id' ]; ?>').DataTable( {
								"processing": true,
								"serverSide": true,
								<?php
								/**
								 * init paging
								 */
								if( !rgar( $form, 'spgfdt_paging' ) ) 
								{
								
									echo '"paging": false,';
									
								} else
								{
									
									echo '"pageLength": ' . $form[ 'spgfdt_paging' ] . ',';
									echo '"lengthMenu": [ 10, 25, 50, 100, 500 ],';
									
								}
								/**
								 * init ordering
								 */
								if( !rgar( $form, 'spgfdt_ordering' ) ) 
									echo '"ordering": false,';
								/**
								 * init searching
								 */
								if( !rgar( $form, 'spgfdt_searching' ) ) 
									echo '"searching": false,';
								/**
								 * set language
								 */
								if( is_file( plugin_dir_path( __FILE__ ) . 'Datatables/languages/datatables.' . $locale . '.json' ) )
								{
											
									?>
									"language": {
										"url": "<?php echo plugins_url( 'Datatables/languages/datatables.' . $locale . '.json', __FILE__ ); ?>"
									},								
									<?php
											
								}
								?>
								"ajax": "<?php echo admin_url( 'admin-ajax.php' ); ?>?action=get_gravitylist"
							} );
						} );						
					</script>
					<?php
						
				}
				
			}
				
		}
				
				
				
		/**
		 * work on the AJAX request to display the datatable
		 */
		function spgfdt_wp_ajax_get_gravitylist()
		{
		
					
			/**
			 * load the class to create the query and return
			 * the columns array to the jQuery DataTable
			 * depending on the gform_entry_source
			 * or return an empty JSON array
			 */
			if( !empty( $_SESSION[ 'dt_params' ][ 'gform_entry_source' ] ) )
				do_action( 'spgfdt_wp_ajax_get_gravitylist_' . $_SESSION[ 'dt_params' ][ 'gform_entry_source' ] );
			else
				echo json_encode(
					array(
						"draw"            => 0,
						"recordsTotal"    => 0,
						"recordsFiltered" => 0,
						"data"            => ''
					) 
				);
				
					
			wp_die();					

					
		}
			
			
				
		/**
		 * work on the AJAX request to display the datatable
		 */
		function spgfdt_wp_ajax_get_gravitylist_GFAPI()
		{
		
					
			/**
			 * load the class to create the query and return
			 * the columns array to the jQuery DataTable
			 */
			require_once( 'classes/gravityforms_datatables.gfapi.php' );
			echo json_encode(
				SSP_GFAPI::simple( $_GET, $_SESSION[ 'dt_columns' ], $_SESSION[ 'dt_params' ] )
			);
						
					
		}


		
		/**
		 * shortcode to display the list
		 */
		function shortcode_gravitylist( $atts ) 
		{

			
			$form_id = $atts[ 'id' ];
			
			
			/**
			 * only do something if we have a form-id
			 */
			if( !$form_id )
				return( '<p>' . __( "No form found", 'spgfdt' ) . '</p>' );


				
			/**
			 * get the form data
			 */
			$form = GFAPI::get_form( $form_id );


			
			/**
			 * get the attributes with the defaults from the form-settings
			 *
			 *	id					:	id of the form
			 *	title				:	display the form title
			 *	fields				:	array with the field-numbers to display
			 *	displayto			:	display the records only to special users
			 *							0 = everyone
			 * 							1 = logged in
			 * 							2 = entry creator
			 * 							3 = only to the admin
			 *	workableby			:	work on the records only to special users
			 *							0 = everyone
			 * 							1 = logged in
			 * 							2 = entry creator
			 * 							3 = only by the admin
			 *	description			:	display the form description
			 *	gform_entry_source	:	data source
			 *							GFAPI = Gravity Forms API
			 *							GFWPDB = Gravity Forms WPDB table
			 */
			extract( 
				shortcode_atts( 
					array(
						'id' => $form_id,
						'title' => 'true',
						'fields' => '',
						'displayto' => $form[ 'spgfdt_displayto' ],
						'workableby' => $form[ 'spgfle_workableby' ],
						'description' => 'true',
						'gform_entry_source' => $form[ 'spgfdt_gform_entry_source' ],
					), 
					$atts 
				) 
			);	

			
			if( empty( $gform_entry_source ) )
				$gform_entry_source = 'GFAPI';
			$title = strtolower( $title ) == "true" ? true : false;
			$description = strtolower( $description ) == "true" ? true : false;


			/**
			 * if the user must be an admin to view the list
			 * end the function if the user isn't an admin
			 */
			if( $displayto > 2 && !GFCommon::current_user_can_any( 'gravityforms_edit_entries' ) )
				return ( '<p>' . __( "You must be an admin to view this list.", 'spgfdt' ) . '</p>' );


			/**
			 * if the user must be logged in to view the list
			 * end the function if the user isn't logged in
			 */
			if( $displayto > 0 && !is_user_logged_in() )
				return ( '<p>' . __( "You must be logged in to view this list.", 'spgfdt' ) . '</p>' );

				

			/**
			 * if we have a fields attribute at the shortcode
			 * we have to build the form_fields array
			 */
			if( $fields )
			{
				
				$fields = explode( ', ', $fields );
				foreach( $fields AS $field )
					$form_fields[] = $form[ 'fields' ][ trim( $field ) ];
					
			} else
			{
				
				/**
				 * get the fields and create a sorted array
				 */
				$form_fields = $form[ 'fields' ];
				uasort( $form_fields, 'uasort_compare_fieldorder');
				
			}
					
						
						
			/** 
			 * loop through the fields and build the
			 * field array of fields wich should be displayed
			 */
			$i = 0;
			foreach( $form_fields AS $field )
			{
					
					
				/** 
				 * display 'adminOnly' fields only to form admins
				 */
				if( !$field[ 'adminOnly' ] || GFCommon::current_user_can_any( 'gravityforms_edit_entries' ) )
				{
						
					/** 
					 * only display fields that are checked at the field-settings
					 */
					if( $field[ 'spgfdt_fieldorder' ] ) 
					{
								
								
						/**
						 * retrieve the column settings depending on the datasource
						 */
						if( $gform_entry_source == 'GFWPDB' )
						{
								
								
							/**
							 * we load the data directly from a WPDB table
							 * so currently some fields are not supported
							 */
							switch( $field[ 'type' ] )
							{
							
								case 'list':
									/*
									 * the 'list' field isn't supported yet
									 */
									break;
								
								case 'name':
									/**
									 * the 'name' field isn't supported yet
									 *
									$columns[] = array( 
										'db' => $field[ 'id' ], 
										'dt' => $i, 
										'wpdb' => array(
											'prefix' => $field[ 'spgfmc_fieldname_name_prefix' ],
											'first' => $field[ 'spgfmc_fieldname_name_first' ],
											'middle' => $field[ 'spgfmc_fieldname_name_middle' ],
											'last' => $field[ 'spgfmc_fieldname_name_last' ],
											'suffix' => $field[ 'spgfmc_fieldname_name_suffix' ]
											),
										'label' => $field[ 'label' ] 
										);
									$i++;
									 */
									break;
								
								case 'address':
									/**
									 * the 'address' field isn't supported yet
									 *
									$columns[] = array( 
										'db' => $field[ 'id' ], 
										'dt' => $i, 
										'wpdb' => array(
											'street_address' => $field[ 'spgfmc_fieldname_address_street_address' ],
											'line2' => $field[ 'spgfmc_fieldname_address_line2' ],
											'city' => $field[ 'spgfmc_fieldname_address_city' ],
											'state' => $field[ 'spgfmc_fieldname_address_state' ],
											'zip' => $field[ 'spgfmc_fieldname_address_zip' ]
											'country' => $field[ 'spgfmc_fieldname_address_country' ]
											),
										'label' => $field[ 'label' ] 
										);
									$i++;
									 */
									break;
								
								default:
									$columns[] = array( 
										'db' => $field[ 'id' ], 
										'dt' => $i, 
										'wpdb' => $field[ 'spgfmc_fieldname' ],
										'label' => $field[ 'label' ] 
										);
									$i++;
									break;
									
							}
							
						} else
						{
						 
							$columns[] = array(
								'db' => $field[ 'id' ], 
								'dt' => $i, 
								'label' => $field[ 'label' ] 
							);
							$i++;
							
						}
						
					}
					
				}
						
			}
						
				
			/**
			 * check if there are any columns to display
			 */
			if( !count( $columns ) )
				return( '<p>' . __( "There are no fields to display", 'spgfdt' ) . '</p>' );
						
						

			/**
			 * get the gfediturl
			 */
			$gfediturl = $form[ 'spgfle_gfediturl' ];
			
			
			/**
			 * if the user must be an admin to work at list
			 * delete the gfediturl if the user isn't an admin
			 */
			if( $workableby > 2 && !GFCommon::current_user_can_any( 'gravityforms_edit_forms' ) )
				unset( $gfediturl );
				

			/**
			 * if the user must be logged in to work at list
			 * delete the gfediturl if the user isn't logged in
			 */
			if( $workableby > 0 && !is_user_logged_in() )
				unset( $gfediturl );

			
							
			if( $gfediturl ) 
			{
				
				$gfediturl = get_permalink( $gfediturl );							
					
				/**
				 * if we have a gfediturl we add a blank column
				 */
				$columns[] = array( 
					'db' => 'action', 
					'dt' => count( $columns ),
					'label' => '&nbsp;'
					);
							
			}
					
							
							
			/**
			 * store the data to the session
			 */
			$_SESSION[ 'dt_columns' ] = $columns;
			$_SESSION[ 'dt_params' ][ 'form_id' ] = $form_id;
			$_SESSION[ 'dt_params' ][ 'displayto' ] = $displayto;
			$_SESSION[ 'dt_params' ][ 'workableby' ] = $workableby;
			$_SESSION[ 'dt_params' ][ 'gform_entry_source' ] = $gform_entry_source;
			
			
			/**
			 * store the WPDB connect data to the session
			 */
			$_SESSION[ 'dt_params' ][ 'tablename' ] = $form[ 'spgfmc_tablename' ];


			/**
			 * display the header
			 */
			$thead .= "			<thead>\n";
			$thead .= "				<tr>\n";
					
			foreach( $columns AS $key => $column )
				$thead .= "					<th scope=\"col\">" . esc_html( $columns[ $key ][ 'label' ] ) . "</th>\n";
					
			$thead .= "				</tr>\n";
			$thead .= "			</thead>\n";
						
			$html .= "	<div class=\"glist_wrapper\" id=\"glist_wrapper_{$form_id}\" >\n";
							
							

			/**
			 * display title and description if needed
			 */
			if( $title != false || $description != false )
			{
						
				$html .= "	<div class=\"glist_heading\">\n";
				if( $title != false )
					$html .= "		<h3 class=\"glist_title\">{$form[ 'title' ]}</h3>\n";
				if( $description != false )
					$html .= "		<span class=\"glist_description\">{$form[ 'description' ]}</span>\n";
				$html .= "	</div>\n";
						
			}
						
			$html .= "	<div class=\"glist_body\">\n";
			$html .= "		<br />\n";

			
			/** 
			 * add a hidden html form if we have a url
			 * to edit
			 */
			if( $gfediturl )
			{
		
				/**
				 * build the hidden html form
				 */
				$html .= "		<form name=\"gravitylist\" action=\"{$gfediturl}\" method=\"post\">\n";
				$html .= "			<input type=\"hidden\" id=\"gform_entry_id\" name=\"gform_entry_id\" value=\"\" />\n";
				$html .= "			<input type=\"hidden\" id=\"gform_entry_mode\" name=\"gform_entry_mode\" value=\"\" />\n";
				$html .= "			<input type=\"hidden\" id=\"gform_entry_source\" name=\"gform_entry_source\" value=\"\" />\n";
				$html .= "		</form>\n";
						
			}

							
			$html .= "		<table id=\"gravitylist_{$_SESSION[ 'dt_params' ][ 'form_id' ]}\" class=\"gravitylist\" cellspacing=\"0\" itemscope=\"itemscope\" itemtype=\"http://schema.org/Table\">\n";

			$html .= $thead;

			$html .= "		</table>\n";
							
							
							
			/**
			 * add an addnew button at the end of the table
			 */
			if( $gfediturl )
			{
					
				if( !empty( $form[ 'spgfle_addnew' ] ) )
				{
						
					if( $form[ 'spgfle_addnew' ] == 'icon' )
						$html .= "<img src=\"" . plugins_url( 'icons/addnew.png', __FILE__ ) . "\" alt=\"" . __( "Addnew", 'spgfle' ) . "\" onClick=\"SetHiddenFormSettings(0, 'addnew', '{$form[ 'spgfdt_gform_entry_source' ]}'\" />";
					else
						$html .= "<button class=\"button button_addnew\" onClick=\"SetHiddenFormSettings(0, 'addnew', '{$form[ 'spgfdt_gform_entry_source' ]}')\">" . __( "Addnew", 'spgfle' ) . "</button>";
						
				}
						
			}

			$html .= "	</div>\n";
							
			return( $html );

			
		}


			
		/**
		 * add a new selectbox to the standard-settings of each supported field
		 * to setup the order of the field in the list
		 */
		function spgfdt_gform_field_standard_settings( $position, $form_id )
		{

    
			if( $position == -1 )
			{

				
				/**
				 * get the form data
				 * and retrieve the number of (supported) fields
				 */
				$form = GFAPI::get_form( $form_id );
				
				$options = "<option value=\"0\"></option>";
				foreach( (array)$form[ 'fields' ] AS $field )
				{
							
					if( in_array( $field[ 'type' ], $this->supported_fields ) )
					{
								
						$i++;
						$options .= "<option value=\"{$i}\">{$i}</option>";
							
					}

				}
						
				?>
				<li class="spgfdt_setting field_setting">
					<label for="spgfdt_fieldorder">
						<?php _e( "Gravitylist Order", 'spgfdt' ); ?>
					</label>
					<select id="spgfdt_fieldorder_value" width="50%" onchange="SetFieldProperty('spgfdt_fieldorder', jQuery(this).val() );"> 
						<?php echo $options; ?>
					</select>
				</li>
				<?php
						
    
			}


		}

			
			
		/**
		 * Support the new advanced setting at the JS to supported field-types
		 */
		function spgfdt_gform_editor_js()
		{

			
			?>
			<script type='text/javascript'>
					
				<?php
				foreach( $this->supported_fields AS $field )
					echo "	fieldSettings[\"{$field}\"] += \", .spgfdt_setting\";\n";
				?>
				jQuery(document).bind("gform_load_field_settings", function(event, field, form) {
					jQuery("#spgfdt_fieldorder_value").val(field.spgfdt_fieldorder);
				});
						
			</script>
			<?php

				
		}
			

		/**
		 * extend the default GravityForms form settings
		 */
		function spgfdt_gform_form_settings( $settings, $form ) 
		{

    
			/* display to user */
			unset( $options );
			$spgfdt_displayto = rgar( $form, 'spgfdt_displayto' );
			$spgfdt_displayto_array = array( 
					0 => __( "everyone", 'spgfdt' ),
					1 => __( "logged in", 'spgfdt' ),
					2 => __( "entry creator", 'spgfdt' ),
					3 => __( "only to the admin", 'spgfdt' )
					);
							
			foreach( $spgfdt_displayto_array AS $key => $value )
			{

				$spgfdt_displayto_selected = '';
				if( $spgfdt_displayto == $key )					
					$spgfdt_displayto_selected = 'selected="selected"';
				$options .= "	<option value=\"{$key}\" {$spgfdt_displayto_selected}>{$value}</option>\n";
								
			}					
					
			$settings[ 'Gravity List' ][ 'spgfdt_settings' ] .= '
				<tr id="spgfdt_displayto_setting_row">
					<th>' . __( "Show records to ", 'spgfdt' ) . '</th>
					<td>
						<select name="spgfdt_displayto">' . $options . '</select>
						<label for="spgfdt_displayto">' . __( "To wich users to entries should be displayed", 'spgfdt' ) . '</label>
					</td>
				</tr>';
					
					
					
			/* enable paging */
			unset( $options );
			$spgfdt_paging = rgar( $form, 'spgfdt_paging' );
			$spgfdt_paging_array = array( '', '10', '25', '50', '100', '500' );
			foreach( $spgfdt_paging_array AS $value )
			{

				$spgfdt_paging_selected = '';
				if( $spgfdt_paging == $value )					
					$spgfdt_paging_selected = 'selected="selected"';
				$options .= "	<option value=\"{$value}\" {$spgfdt_paging_selected}>{$value}</option>\n";
								
			}					

			$settings[ 'Gravity List' ][ 'spgfdt_settings' ] .= '
				<tr id="spgfdt_paging_setting_row">
					<th>' . __( "Enable Paging ", 'spgfdt' ) . '</th>
					<td>
						<select name="spgfdt_paging">' . $options . '</select>
						<label for="spgfdt_paging">' . __( "Enable the Paging-Mode at the DataTable", 'spgfdt' ) . '</label>
					</td>
				</tr>';


			
			/* enable ordering */
			$spgfdt_ordering_checked = '';
			if( rgar( $form, 'spgfdt_ordering' ) )
				$spgfdt_ordering_checked = 'checked="checked"';
					
			/* enable searching */
			$spgfdt_searching_checked = '';
			if( rgar( $form, 'spgfdt_searching' ) )
				$spgfdt_searching_checked = 'checked="checked"';

				
			$settings[ 'Gravity List' ][ 'spgfdt_settings' ] .= '
				<tr id="spgfdt_ordering_setting_row">
					<th>' . __( "Enable ordering", 'spgfdt' ) . '</th>
					<td>
						<input type="checkbox" id="spgfdt_ordering" name="spgfdt_ordering" value="true" ' . $spgfdt_ordering_checked . ' />
						<label for="spgfdt_ordering">' . __( "Enable the Ordering-Mode at the DataTable", 'spgfdt' ) . '</label>
					</td>
				</tr>
				<tr id="spgfdt_searching_setting_row">
					<th>' . __( "Enable Searching", 'spgfdt' ) . '</th>
					<td>
						<input type="checkbox" id="spgfdt_searching" name="spgfdt_searching" value="true" ' . $spgfdt_searching_checked . ' />
						<label for="spgfdt_searching">' . __( "Enable the Search-Box at the DataTable", 'spgfdt' ) . '</label>
					</td>
				</tr>
				';
						
						
				
			/**
			 * if we are connected to a WPDB datatbase table
			 * add support the build the Gravitylist from the WPDB table
			 * instead of the GFAPI
			 */
			if( $form[ 'spgfmc_tablename' ] )
			{

					
				$options = '';
				$options_array = array(
						'GFAPI' => __( "Gravity Forms API", 'spgfdt' ),
						);
						
				$options_array = apply_filters( 'spgfdt_gform_entry_source_options', $options_array );
				
									
				$spgfdt_gform_entry_source = rgar( $form, 'spgfdt_gform_entry_source' );
				foreach( $options_array AS $key => $value )
				{
						
					$selected = '';
					if( $spgfdt_gform_entry_source == $key )
						$selected = ' selected="selected"';
						
					$options .= "<option value=\"{$key}\" {$selected}>{$value}</option>\n";
						
				}
					
				$settings[ 'Gravity List' ][ 'spgfdt_settings' ] .= '
					<tr id="spgfdt_gform_entry_source_setting_row">
						<th>' . __( "Preferred Data Source", 'spgfdt' ) . '</th>
						<td>
							<select id="spgfdt_gform_entry_source" name="spgfdt_gform_entry_source">' . $options . '</select>
							<label for="spgfdt_gform_entry_source">' . __( "Wich Data-Source do you prefer to build the list.", 'spgfdt' ) . '</label>
						</td>
					</tr>';	
							
			}
			
					
			return( $settings );

				
		}
 


		/**
		 * save the extended settings
		 */
		function spgfdt_gform_pre_form_settings_save( $form )  
		{


			/**
			 * set the gform_entry_source to GFAPI if empty
			 */
			$form[ 'spgfdt_gform_entry_source' ] = rgpost( 'spgfdt_gform_entry_source' );
			if( empty( $form[ 'spgfdt_gform_entry_source' ] ) )
				$form[ 'spgfdt_gform_entry_source' ] = 'GFAPI';
					 
			$form[ 'spgfdt_displayto' ] = rgpost( 'spgfdt_displayto' );
			$form[ 'spgfdt_searching' ] = rgpost( 'spgfdt_searching' );
			$form[ 'spgfdt_ordering' ] = rgpost( 'spgfdt_ordering' );
			$form[ 'spgfdt_paging' ] = rgpost( 'spgfdt_paging' );

			return( $form );


		}

				
	}

	
	/* instance class */
	$SpGfDataTables= new SpGfDataTables();

	
?>