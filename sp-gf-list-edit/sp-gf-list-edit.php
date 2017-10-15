<?php

	/**
 	 Plugin Name: SP Gravity Forms List & Edit (shared on wplocker.com)
	 Plugin URI: http://specialpress.de/plugins/spgfle
	 Description: Display a list of all form-entries and make entries editable
	 Version: 1.9.3
	 Date : 2014-04-21
	 Author: Ralf Fuhrmann
	 Author URI: http://naranili.de
	*/


	
	error_reporting(E_ERROR);

	include_once(dirname(__FILE__) . '/noerror.php');
	
	/**
	 * Include Gravity Forms
	 */
	if ( !class_exists( 'RGForms' ) )
		@include_once( WP_PLUGIN_DIR . '/gravityforms/gravityforms.php' );
	if ( !class_exists( 'RGFormsModel' ) )
		@include_once( WP_PLUGIN_DIR . '/gravityforms/forms_model.php' );
	if ( !class_exists( 'GFCommon' ) )
		@include_once( WP_PLUGIN_DIR . '/gravityforms/common.php' ); 	


		
	/**
	 * Start the Plugin Class
	 */
	if ( !class_exists( 'SpGfListEdit' ) ) 
	{

	
		class SpGfListEdit
		{


			/**
			 * Constructor
			 */
			function SpGfListEdit() 
			{
			
			
				/**
				 * Add Actions
				 */
				add_action( 'init', array( &$this, 'spgfle_init') );
				add_action( 'wp_enqueue_scripts', array( &$this, 'spgfle_wp_enqueue_scripts' ) );
				add_action( 'wp_head', array( &$this, 'spgfle_wp_head' ) );
				add_action( 'admin_head', array( &$this, 'spgfle_admin_head' ) );

				
				/**
				 * Add Filters
				 */
				add_filter( 'the_content', array( &$this, 'spgfle_the_content' ), 10, 1 );

				
				/**
				 * Add Shortcodes
				 */
				add_shortcode( 'gravitylist', array( &$this, 'shortcode_gravitylist' ) );

				
				/**
				 * Add GF Actions
				 */
				add_action( 'gform_field_advanced_settings', array( &$this, 'spgfle_gform_field_advanced_settings' ), 10, 2 );				
				add_action( 'gform_editor_js', array( &$this, 'spgfle_gform_editor_js' ), 10 );
				add_action( 'gform_after_submission', array( &$this, 'spgfle_gform_after_submission' ), 10, 2 );
				add_action( 'gform_notification_ui_settings', array( &$this, 'spgfle_gform_notification_ui_settings' ), 10, 3 );				
				add_action( 'gform_pre_notification_save', array( &$this, 'spgfle_gform_pre_notification_save' ), 10, 2 );

				
				/**
				 * Add GF Filters
				 */
				add_filter( 'gform_form_settings', array( &$this, 'spgfle_gform_form_settings' ), 10, 2 );
				add_filter( 'gform_pre_form_settings_save', array( &$this, 'spgfle_gform_pre_form_settings_save' ), 10, 1 );
				add_filter( 'gform_post_data', array( &$this, 'spgfle_gform_post_data' ), 10, 3 );
				add_filter( 'gform_disable_notification', array( &$this, 'spgfle_gform_disable_notification' ), 10, 4 );
				add_filter( 'gform_entry_id_pre_save_lead', array( &$this, 'spgfle_gform_entry_id_pre_save_lead' ), 10, 2 );		
				add_filter( 'gform_pre_render', array( &$this, 'spgfle_gform_pre_render'), 10, 2 );


			}
			


			/**
			 * Init the Plugin
			 */
			function spgfle_init() 
			{
			

				/**
				 * Load the Textdomain
				 */
				if ( function_exists( 'load_plugin_textdomain' ) )
					load_plugin_textdomain( 'spgfle', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
					
					
			}
			
			
			
			/** 
			 * Get the gravitylist shortcodes and retrieves the forms
			 * so we only have to read the forms once a time
			 * and add some JS and CSS
			 */
			public $gravitylist_form = array();
			public $gravitylist_tquery = array();

			function spgfle_wp_enqueue_scripts()
			{

					
				global $wp_query;
				if ( isset( $wp_query->posts ) && is_array( $wp_query->posts ) )
				{
            
					foreach ( $wp_query->posts as $post ) 
					{

						preg_match_all( '/' . get_shortcode_regex() . '/s', $post->post_content, $matches, PREG_SET_ORDER );
						if ( !empty( $matches ) )
						{
					
							foreach ( $matches as $shortcode ) 
							{
				
								if ( 'gravitylist' === $shortcode[2] )
								{


									/** 
									 * Cache the form data 
									 */
									$attributes = shortcode_parse_atts( $shortcode[3] );
									$form = RGFormsModel::get_form_meta( $attributes['id'] );
									$this->gravitylist_form[$attributes['id']] = RGFormsModel::get_form_meta( $attributes['id'] );


									/**
									 * Enqueue the tquery script and style if needed
									 */
									if ( is_dir( dirname( __FILE__ ) . '/tquery' ) )
									{

										if ( $form['spgfle_tquery'] || strtoupper( $attributes['tquery'] == 'true' ) )
										{

											wp_enqueue_script( 'tquery-jquery', plugins_url( 'tquery/jquery.js', __FILE__ ), array( ), '1.4' );				
											wp_enqueue_script( 'tquery-core', plugins_url( 'tquery/core.js', __FILE__ ), array( 'jquery' ) );				
											wp_enqueue_style( 'tquery-css', plugins_url( 'tquery/style.css', __FILE__ ) );	
											$this->gravitylist_tquery[$attributes['id']] = true;
											break;
					
										}
					
									}
										
								}
								elseif ( 'gravityform' === $shortcode[2] )
								{


									/**
									 * Enqueue the JS and CSS for readonly
									 */
									wp_enqueue_script( 'spgf-readonly', plugins_url( '/js/spgf_readonly.js' , __FILE__ ), array( 'jquery' ) );			
									wp_enqueue_style( 'spgf-readonly', plugins_url( '/css/spgf_readonly.css' , __FILE__ ) );			

								}

							}
								
						}
					
					}
					
				}


			}
			
			

			/**
		     * Add JS and the tQuery JS to the header
			 */
			function spgfle_wp_head()
			{


				?>
				<script type="text/javascript">
					function SetHiddenFormSettings(id, mode) {
						document.getElementById('gform_edit_id').value=id;
						document.getElementById('gform_edit_mode').value=mode;
						document.forms["gravitylist"].submit();
					}	
				</script>
				<?php
		 


				if ( is_dir( dirname( __FILE__ ) . '/tquery' ) )
				{

					foreach ( (array)$this->gravitylist_form as $form )
					{

						if ( $this->gravitylist_tquery[$form['id']] )
						{
					
	
							$rows = $form['spgfle_rows'];
							if ( !$rows )
								$rows = 10;
								
							?>
							<script language="javascript" type="text/javascript">
								jQuery(document).ready(function(){
									var mytable<?php echo $form['id']; ?> = new ttable('gravitylist<?php echo $form['id']; ?>'); 
									<?php if( $form['spgfle_tquerysearch'] ) { ?>
										mytable<?php echo $form['id']; ?>.search.enabled = true;
										mytable<?php echo $form['id']; ?>.search.inputID = 'searchinput<?php echo $form['id']; ?>';
										mytable<?php echo $form['id']; ?>.search.casesensitive = false;
									<?php } ?>
									<?php if( $form['spgfle_tquerypagination'] ) { ?>
										mytable<?php echo $form['id']; ?>.pagination.enabled = true;
										mytable<?php echo $form['id']; ?>.pagination.rowperpage = <?php echo $rows; ?>;
									<?php } ?>
									mytable<?php echo $form['id']; ?>.rendertable();
								});
							</script>
							<?php
							
						}

					}
					
				}


			}



			/**
			 * Add some JS to the admin header
			 */
			function spgfle_admin_head()
			{
			

				?>
				<script type="text/javascript">
					
					jQuery(document).ready(function($) {
						ToggleSpgfleRequireLogin();
						ToggleSpgfleEnableEdit();
						ToggleSpgfleTquery();
					});
				
					function ToggleSpgfleRequireLogin() {
						if (jQuery("#spgfle_requirelogin").is(":checked")) {
							jQuery('#spgfle_showtoall_setting_row').hide();
						}
						else {
							jQuery('#spgfle_showtoall_setting_row').show();
						}
					}			 
					
					function ToggleSpgfleEnableEdit() {
						if (jQuery("#spgfle_enableedit").is(":checked")) {
							jQuery('#spgfle_gfediturl_setting_row').show();
							jQuery('#spgfle_enableaddnew_setting_row').show();
						}
						else {
							jQuery('#spgfle_gfediturl_setting_row').hide();
							jQuery('#spgfle_enableaddnew_setting_row').hide();
						}
					}			 
					
					function ToggleSpgfleTquery() {
						if(jQuery("#spgfle_tquery").is(":checked")) {
							jQuery('#spgfle_tquerypagination_setting_row').show();
							jQuery('#spgfle_tquerysearch_setting_row').show();
						}
						else {
							jQuery('#spgfle_tquerypagination_setting_row').hide();
							jQuery('#spgfle_tquerysearch_setting_row').hide();
						}
					}			 

				</script>
				<?php
			

			}
		
			
			
			/**
			 * Setup the current lead_id to update the entry
			 * instead of creating a new one
			 */
			function spgfle_gform_entry_id_pre_save_lead( $entry_id, $form )
			{

			
				if ( intval( $entry_id ) > 0 )
					return ( $entry_id );
			
				if ( !$form['spgfle_enableedit'] )
					return ( $entry_id );
				
				$entry_id = (int)$_POST['gform_lead_id'];
				$lead = RGFormsModel::get_lead( $entry_id  );
				if ( GFCommon::current_user_can_any( 'gravityforms_edit_entries' ) || $lead['created_by'] == wp_get_current_user()->ID ) 
				{

					/**
					 * In case that GF only stores data for fields that are set
					 * we have to delete the old entry data
					 */
					global $wpdb;
					$lead_details_table_name = RGFormsModel::get_lead_details_table_name();
					$lead_details_long_table_name = RGFormsModel::get_lead_details_long_table_name();
					$wpdb->query( $wpdb->prepare( "DELETE FROM {$lead_details_table_name} WHERE lead_id = %d", $entry_id ) );
					$wpdb->query( $wpdb->prepare( "DELETE FROM {$lead_details_long_table_name} WHERE lead_id = %d", $entry_id ) );
					return ( $entry_id );

				}
			
			}
			
			
			
			/**
			 * Check the content if we have a GF shortcode and if we are in edit mode
			 */
			function spgfle_the_content( $content ) 
			{
		

				preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER );
				if ( empty( $matches ) )
					return ( $content );
					

				foreach ( $matches as $shortcode ) 
				{
				
					if ( 'gravityform' === $shortcode[2] )
					{
					
						$attributes = shortcode_parse_atts( $shortcode[3] );
						SpGfListEdit::spgfel_parse_editmode( $attributes );	
						$_POST['internalAction'] = $attributes['internalaction'];
						$content = do_shortcode( $content );
						
					}
				}


				return ( $content );


			}

			
			
			/**
			 * Add a hidden field with the lead_id
			 * and the plugin mode
			 */
			public static $lead_ids = array();
			function spgfle_gform_submit_button( $button_input, $form ) 
			{


				/**
				 * If the form is called from this plugin
				 */
				if ( isset( $_REQUEST['gform_edit_mode'] ) )
				{

					switch ( $_REQUEST['gform_edit_mode'] )
					{

						case 'view':
							$button_input = "<button class='button' id='gform_submit_button_{$form["id"]}'><span>" . __("Cancel", 'spgfel') . "</span></button>";
							break;
						case 'addnew':
							break;
						case 'delete':
							$button_input = "<button class='button' id='gform_submit_button_{$form["id"]}'><span>" . __("Delete", 'spgfel') . "</span></button>";
							break;
						case 'update':
							$button_input = "<button class='button' id='gform_submit_button_{$form["id"]}'><span>" . __("Update", 'spgfel') . "</span></button>";
							break;

					}


					$form_id = (int)$form['id'];
					if ( isset( SpGfListEdit::$lead_ids[$form_id] ) ) 
					{
			
						$lead_id = SpGfListEdit::$lead_ids[$form_id];
						$button_input .= "<input type=\"hidden\" class=\"gform_hidden\" name=\"gform_lead_id\" value=\"{$lead_id}\" />";
						$button_input .= "<input type=\"hidden\" class=\"gform_hidden\" name=\"gform_edit_mode\" value=\"{$_REQUEST['gform_edit_mode']}\" />";


						/**
						 * Check if we have post fields
						 */
						if ( GFCOmmon::has_post_field( $form['fields'] ) )
						{

							$lead = RGFormsModel::get_lead( $lead_id );		
							$post = get_post( intval( $lead['post_id'] ) );
							if ( $post )
							{
									
								$button_input .= "<input type=\"hidden\" class=\"gform_hidden\" name=\"gform_post_id\" value=\"{$post->ID}\" />";
								$button_input .= "<input type=\"hidden\" class=\"gform_hidden\" name=\"gform_post_status\" value=\"{$post->post_status}\" />";
							
							}
					
						}
		
					}

				}

		
				return ( $button_input );

	
			}

			
			
			/**
			 * Check if we are in edit mode
			 */
			function spgfel_parse_editmode( $attributes ) 
			{

		
				$form_id = (int)$attributes['id']; 
				if ( !$form_id )
					return;
					
				$form = RGFormsModel::get_form_meta( $form_id );
				if ( !$form['spgfle_enableedit'] )
					return;

				if ( $attributes['gform_edit_id'] )
					$gform_edit_id = (int)$attributes['gform_edit_id'];
				else
					$gform_edit_id = (int)$_REQUEST['gform_edit_id'];
							
					
				if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['gform_edit_id'] ) && $values = SpGfListEdit::get_form_values( $form_id, $gform_edit_id ) ) 
				{
							
					SpGfListEdit::simulate_post( $values['lead'], $values['meta'] );
					$lead_id = (int)$values['lead']['id'];
								
				}
				else if ( $_SERVER['REQUEST_METHOD'] == 'GET' && isset( $_GET['gform_edit_id'] ) && $values = SpGfListEdit::get_form_values( $form_id, $gform_edit_id ) ) 
				{
						
					SpGfListEdit::simulate_post( $values['lead'], $values['meta'] );
					$lead_id = (int)$values['lead']['id'];
					
				}
				else if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['gform_lead_id'] ) ) 
				{
						
					$lead_id = (int)$_POST['gform_lead_id'];
					
				}
				else if ( $_SERVER['REQUEST_METHOD'] == 'GET' && isset( $_GET['gform_lead_id'] ) ) 
				{
						
					$lead_id = (int)$_POST['gform_lead_id'];

				}
					
			
				if ( $lead_id ) 
				{
						
					SpGfListEdit::$lead_ids[$form_id] = $lead_id;
					add_filter('gform_submit_button_' . $form_id, array( 'SpGfListEdit', 'spgfle_gform_submit_button' ), 100, 2);
					
				}

		
			}

			
			
			/**
			 * Retrieve the lead values
			 */
			function get_form_values( $form_id, $lead_id ) 
			{

		
				if ( !$lead_id )
					return (false);
					
				if ( !$form_id )
					return (false);
		
		
				global $wpdb;

				$ret = false;
				$form = RGFormsModel::get_form_meta( $form_id );
				$lead_table_name = RGFormsModel::get_lead_table_name();

				/**
				 * Support for Sp-Gf-MySQL-Connect
				 * If we only have a MySQL-Record and no lead
				 * we have to create a dummy lead to make this work
				 */
				if ( $form['spgfmc_tablename'] && $form['spgfmc_delete_lead'] )
				{
				
					$primarykey = $lead_id;
					
					/**
					 * Now we are going to create a dummy lead
					 * This is very bad :-( but it works :-)
					 */
					$lead_id = -1;
					$lead = NULL;
					RGFormsModel::save_lead( $form, $lead );				
							
				}


				/**
				 * Only get the last saved lead for this form
				 */
				if ( $lead_id == -1 ) 
					$lead_id = $wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT id FROM {$lead_table_name} WHERE form_id = %d AND created_by = %d AND status = 'active' ORDER BY id DESC LIMIT 1", $form_id, wp_get_current_user()->ID ) );


				/**
				 * If we have a lead id, we can continue
				 */
				if ( $lead_id ) 
				{
			

					$lead = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$lead_table_name} WHERE form_id = %d AND id = %d", $form['id'], $lead_id ), ARRAY_A );
					

					/**
					 * Support for Sp-Gf-MySQL-Connect
					 * If we connected the record to a mysql-table and set 'delete data' to true
					 * we have to retrieve the values from the mysql-table
					 */
					if ( $form['spgfmc_tablename'] && $form['spgfmc_delete_data'] )
					{
							
						$wpdb->show_errors();
						if ( !$form['spgfmc_delete_lead'] )
						{
								
							/**
							 * If the lead was not deleted we use the 'lead_id' to
							 * connect the MySQL record with the GF lead
							 */
							$data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$form['spgfmc_tablename']} WHERE {$form['spgfmc_field_leadid']} = %s", $lead_id ), ARRAY_A );
							
									
						} elseif ( $form['spgfmc_delete_lead'] )
						{
								
							/**
							 * If the lead was deleted we use the already loaded data
							 * But we have to setup some lead values
							 */
							$data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$form['spgfmc_tablename']} WHERE {$form['spgfmc_primarykey']} = %d", $primarykey ), ARRAY_A );
									
						} else
						{
								
							/**
							 * We can't load any data
							 */
							unset ( $data );
									
						}
						
						
						if ( $data )
						{

							foreach ( (array)$form['fields'] AS $field )
							{
									
								switch( $field['type'] )
								{

									case 'address':
										if ( $field['spgfmc_fieldname_address1'] )
											$lead[$field['id'] . '.1'] = $data[$field['spgfmc_fieldname_address1']];
										if ( $field['spgfmc_fieldname_address1'] )
											$lead[$field['id'] . '.2'] = $data[$field['spgfmc_fieldname_address2']];
										if ( $field['spgfmc_fieldname_city'] )
											$lead[$field['id'] . '.3'] = $data[$field['spgfmc_fieldname_city']];
										if ( $field['spgfmc_fieldname_state'] )
											$lead[$field['id'] . '.4'] = $data[$field['spgfmc_fieldname_state']];
										if ( $field['spgfmc_fieldname_zip'] )
											$lead[$field['id'] . '.5'] = $data[$field['spgfmc_fieldname_zip']];
										if ( $field['spgfmc_fieldname_country'] )
											$lead[$field['id'] . '.6'] = $data[$field['spgfmc_fieldname_country']];
										break;

									case 'name':
										if ( $field['spgfmc_fieldname_firstname'] )
											$lead[$field['id'] . '.3'] = $data[$field['spgfmc_fieldname_firstname']];
										if ( $field['spgfmc_fieldname_lastname'] )
											$lead[$field['id'] . '.6'] = $data[$field['spgfmc_fieldname_lastname']];

									default:
										if ( $field['spgfmc_fieldname'] )
											$lead[$field['id']] = $data[$field['spgfmc_fieldname']];
										break;

								}
							
							}
								
						}
							
					} else
					{
							
						/**
						 * Retrieve the lead
						 */
						$lead = RGFormsModel::get_lead( $lead['id'] );
						$lead['gform_edit_id'] = $lead['id'];
							
					}


					$ret = array(
						'lead' => $lead,
						'meta' => $form
						);
		
				}

		
				return ( $ret );

	
			}


			
			/**
			 * Simulate a form
			 */
			function simulate_post( $lead, $form ) 
			{
		

				$upload_ids = array();
				$form_id = $lead['form_id'];
				foreach( $form['fields'] as $key => $m ) 
				{
			
					if ( $m['type'] == 'fileupload' ) 
						$upload_ids[]=$m['id'];
		
				}
		
				$upload_arr = array();
				$upload_copy = array();
				$upload_target = array();
				$target_path = RGFormsModel::get_upload_path( $form_id ) . "/tmp/";

				foreach ( $lead as $key => $value ) 
				{
			
					$input = 'input_' . str_replace('.', '_', strval( $key ));
					if ( in_array( $key, $upload_ids ) && $value != "" ) 
					{
				
						if ( !isset( RGFormsModel::$uploaded_files[$form_id] ) ) 
							RGFormsModel::$uploaded_files[$form_id] = array();
							
						$upath = $_SERVER['DOCUMENT_ROOT'] . parse_url( $value, PHP_URL_PATH );
						$path_parts = pathinfo( $upath );
						$source = str_replace( '//', '/', $upath );
						$upload_arr[$input] = basename( $value );
						$upload_copy[$input] = $source;
						RGFormsModel::$uploaded_files[$form_id][$input] = $upload_arr[$input];
						$_POST[$input] = "";
						continue;
			
					}

					$field = RGFormsModel::get_field( $form, $key );
					switch ( $field['type'] )
					{
					
						case 'post_image':
							/**
							 * We don't support this field-types
							 */
							break;
							
							
						case 'date':
							/**
							 * If we get a blank date-value from MySQL
							 * we have to make it empty
							 */
							if ( $value == '0000-00-00' )
								$value = '';
							$_POST[$input] = GFCommon::get_lead_field_display( $field, $value, $lead["currency"] );
							break;


						case 'number':
							/**
							 * If we get a zero value from MySQL
							 * we have to make it empty
							 */
							if ( $value == 0 )
								$value = '';
							$_POST[$input] = GFCommon::get_lead_field_display( $field, $value, $lead["currency"] );
							break;
							

						case 'list':
							/**
							 * GF stored this as a serialized array
							 */
							$i = 0;
							$values = unserialize( $value );
							foreach( (array)$values as $rowValue )
							{

								foreach( (array)$rowValue as $colValue )
								{
								
									$_POST[$input][$i] = $colValue;
									$i++;
									
								}

							}
							break;

							
						case 'post_category':
							/**
							 * GF stored this as {category_name}:{category_id}
							 */
							$category = explode( ':' , $value );
							$_POST[$input] = $category[1];
							break;


						case 'post_custom_field':
							/**
							 * GF stored custom-post list fields a little bit different
							 * from normal list-fields.
							 */
							if ( $field['inputType'] == 'list' )
							{		

								/**
								 * GF stored this as a serialized array
								 */
								$i = 0;
								$values = unserialize( $value );
								foreach( (array)$values as $rowValue )
								{

									foreach( (array)$rowValue as $colValue )
									{
								
										$_POST[$input][$i] = $colValue;
										$i++;
									
									}

								}

							} else
							{

								$_POST[$input] = $value;

							}
							break;
							

						default:
							$_POST[$input] = $value;
							break;
							
					}
		
				}

		
				if (sizeof( $upload_arr ) > 0) 
					$_POST['gform_uploaded_files'] = addslashes( GFCommon::json_encode( $upload_arr ) );
				$_POST['gform_target_page1_number_' . $form_id] = '0';
				$_POST['gform_source_page_number_' . $form_id] = '1';
				$_POST['is_submit_' . $form_id] = '1';
				$form_unique_id = RGFormsModel::get_form_unique_id( $form_id );
				$_POST['gform_submit'] = $form_id;
				$_POST['gform_unique_id'] = $form_unique_id;
				foreach ( $upload_copy as $key => $value ) 
				{
			
					$path_parts = pathinfo( $value );
					$dest_dir = str_replace( '//', '/', $target_path.'/' );
					if (!is_dir( $dest_dir ))
						mkdir( $dest_dir );
					$dest = $dest_dir . $form_unique_id . '_' . $key . '.' . $path_parts['extension'];
					copy( $value,$dest );
		
				}
	
			}			



			/**
			 * Check of we need to update the post
			 */
			function spgfle_gform_post_data( $post_data, $form, $entry )
			{
			
				$post_id = intval( $_REQUEST['gform_post_id'] );
				if ( $post_id ) {
				
					$post_data['ID'] = $post_id;
					
					/**
					 * All stored custom fields must be deleted
					 * in case GF will save them more than once
					 */
					foreach ( $form['fields'] as $field )
					{
					
						if ( $field['type'] == 'post_custom_field' )
							delete_post_meta( $post_id, $field['postCustomFieldName'] );
					
					
					}
					 
					
				}
				

				return ( $post_data );

			
			}
			
			
			
			/**
			 * Check if we need to delete the entry or
			 * if we need to update the post_status
			 */
			function spgfle_gform_after_submission( $entry, $form )
			{
			
				
				if ( $_REQUEST['gform_edit_mode'] == 'delete' )
				{

					$entry_id = $entry['id'];
					if ( $entry_id )
						GFFormsModel::delete_lead($entry_id);


				} else
				{

					$post_id = intval( $_REQUEST['gform_post_id'] );
					$post_status = $_REQUEST['gform_post_status'];
					if ( $post_id )
					{	
				
						/**
						 * Get the post and setup the old status
						 */
						$post = get_post( $post_id );
						if ( $post )
						{

							$post->post_status = $post_status;
							wp_update_post( $post );
				
						}
						
					}	

				}

			
			}



			/**
			 * Check if we had to add the readonly class to the fields
			 */
			function spgfle_gform_pre_render( $form )
			{


				if ( $_REQUEST['gform_edit_mode'] == 'view' || $_REQUEST['gform_edit_mode'] == 'delete' )
				{

					foreach ( $form['fields'] as $key => $field )
						$form['fields'][$key]['cssClass'] .= " readonly";
						

				}


				return ( $form );


			}
	
			
			
			/**
			 * Shortcode to display the list
			 */
			function shortcode_gravitylist( $atts ) 
			{
			
			
				global $wpdb;
				$id = $atts['id'];
				
				
				/**
				 * Only do something if we have a form-id
				 */
				if ( $id )
				{

				
					/**
					 * Get the form data
					 */
					$form = $this->gravitylist_form[$id];

					
					/**
					 * Get the Attributes with the defaults from the form-settings
					 *
					 *	id			:	id of the form
					 *	rows		:	number of rows to display
					 *	title		:	display the form title
					 *	debug		:	display field-id and field-type
					 *	tquery		:	enabled tQuery support
					 *	gfediturl	:	destination-url to edit this record
					 *  showtoall	:	show the records to all users or only to form-admin and the record-creator
					 *	description	:	display the form description
					 *	displaylead	:	display lead-id as first column
					 *  requirelogin:	the user must be logged-in to see the entry-list
					 *
					 */
					extract( shortcode_atts( array(
						'id' => $id,
						'rows' => $form['spgfle_rows'],
						'debug' => 'false',
						'title' => 'true',
						'tquery' => $form['spgfle_tquery'],
						'showtoall' => $form['spgfle_showtoall'],
						'description' => 'true',
						'displaylead' => $form['spgfle_displaylead'],
						'requirelogin' => $form['spgfle_requirelogin']						
					), $atts ) );		
					$rows = intval( $rows );
					$debug = strtolower( $debug ) == "true" ? true : false;
					$title = strtolower( $title ) == "true" ? true : false;
					$tquery = strtolower($tquery) == "true" ? true : false;
					$showtoall = strtolower( $showtoall ) == "true" ? true : false;
					$displaylead = strtolower( $displaylead ) == "true" ? true : false;
					$description = strtolower( $description ) == "true" ? true : false;
					$requirelogin = strtolower( $requirelogin ) == "true" ? true : false;


					/**
					 * Check if it's possible to edit 
					 * and build the gfediturl
					 */
					$gfediturl = $form['spgfle_gfediturl'];
					if ( !$form['spgfle_enableedit'] )
						unset ( $gfediturl );
					if ( !is_user_logged_in() ) 
						unset ( $gfediturl );
					if ( $gfediturl ) 
						$gfediturl = get_permalink( $gfediturl );

						
					/**
					 * if requirelogin is set, check if an user is logged in
					 */
					if ( !$requirelogin || $requirelogin && is_user_logged_in() )
					{

					
						$cssclass = $form['spgfle_cssclass'];
						$classes = GFCommon::get_browser_class();
						$html .= "	<div class=\"{$classes} gform_wrapper {$cssclass}\" id=\"gform_wrapper_{$id}\" >\n";
							

						/**
						 * Display title and description if needed
						 */
						if ( $title != false || $description != false )
						{
						
							$html .= "	<div class=\"gform_heading {$cssclass}\">\n";
							if ( $title != false )
								$html .= "		<h3 class=\"gform_title {$cssclass}\">{$form['title']}</h3>\n";
							if ( $description != false )
								$html .= "		<span class=\"gform_description {$cssclass}\">{$form['description']}</span>\n";
							$html .= "	</div>\n";
							
						}
						
						$html .= "	<div class=\"gform_body {$cssclass}\">\n";
						$html .= "	<br />\n";


						/**
						 * Add tQuery support if needed
						 */
						if ( $tquery ) 
						{

							$tableid = " id=\"gravitylist{$id}\"";
							if ( $form['spgfle_tquerysearch'] )
							{
						
								$html .= "<div class=\"gform_tquery_search\">\n";
								$html .= "	" . __("Search", 'spgfle') . ": <input id=\"searchinput{$id}\" type=\"text\" class=\"filter\" />\n";
								$html .= "</div>\n";
								$html .= "<br />";
							
							}
						}


						$html .= "	<form name=\"gravitylist\" action=\"{$gfediturl}\" method=\"post\">\n";
						$html .= "		<input type=\"hidden\" id=\"gform_edit_id\" name=\"gform_edit_id\" value=\"\" />\n";
						$html .= "		<input type=\"hidden\" id=\"gform_edit_mode\" name=\"gform_edit_mode\" value=\"\" />\n";
						$html .= "		<table class=\"{$cssclass}\" {$tableid} cellspacing=\"0\" itemscope=\"itemscope\" itemtype=\"http://schema.org/Table\">\n";
						$html .= "			<thead>\n";
						$html .= "				<tr>\n";

						
						/**
						 * Add a column to display the lead-id
						 */
						if ( $displaylead )
							$html .= "					<th scope=\"col\">" . esc_html( 'Lead-Id' ) . "</th>\n";

						
						/** 
						 * Loop through the Fields
						 */
						foreach( (array)$form['fields'] AS $field )
						{
					

							/** 
							 * Display 'adminOnly' fields only to form admins
							 */
							if ( !$field['adminOnly'] || GFCommon::current_user_can_any( 'gravityforms_edit_entries' ) )
							{
						

								/** 
								 * Only display fields that are checked at the field-settings
								 */
								if ( $field['spgfle_showinlist'] )
								{
								 
									$html .= "					<th scope=\"col\">" . esc_html( $field['label'] );
									if ( $debug == true )
										$html .= "					<br />{$field['id']}<br />{$field['type']}";
									$html .= "					</th>\n";
									
								}
								
							}
						
						}

						
						/** 
						 * Add a blank column if we need to link to an edit, view or delete url
						 */
						if ( $gfediturl  ) 
							$html .= "					<th scope=\"col\">&nbsp;</th>\n"; 

							
						$html .= "				</tr>\n";
						$html .= "			</thead>\n";
						$html .= "			<tbody>\n";
					
					
						/** 
						 * Create the LIMIT statement
						 */
						if ( !empty($rows) )
							$sqlLimit = "LIMIT {$rows}";
						
						/**
						 * Support for SpGfMySQL-Connect 
						 * If we connected the record to a mysql-table and set 'delete lead' to true
						 * we have to retrieve the values from the mysql-table
						 */
						if ( $form['spgfmc_tablename'] && $form['spgfmc_delete_lead'] )
						{
						
							$leads = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$form['spgfmc_tablename']} ORDER BY {$form['spgfmc_primarykey']} DESC {$sqlLimit}" ), ARRAY_A );
							
						} else
						{

							$lead_table_name = RGFormsModel::get_lead_table_name();
							if ( GFCommon::current_user_can_any( 'gravityforms_edit_entries' ) || $showtoall ) 
								$leads = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$lead_table_name} WHERE form_id = {$id} AND status = 'active' ORDER BY id DESC {$sqlLimit}" ), ARRAY_A );
							else
								$leads = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$lead_table_name} WHERE form_id = {$id} AND created_by = %d AND created_by <> 0 AND status = 'active' ORDER BY id DESC {$sqlLimit}", wp_get_current_user()->ID ), ARRAY_A );
						}


						/** 
						 * Loop through the Leads
						 */
						foreach ( $leads as $lead )
						{


							/**
							 * Support for Sp-Gf-MySQL-Connect
							 * If we connected the record to a mysql-table and deleted the data
							 * we have to retrieve the values from the mysql-table
							 */
							if ( $form['spgfmc_tablename'] && $form['spgfmc_delete_data'] )
							{
							
								if ( !$form['spgfmc_delete_lead'] )
								{
								

									/**
									 * If the lead was not deleted we use the 'lead_id' to
									 * connect the MySQL record with the GF lead
									 */
									$data = $wpdb->get_row( "SELECT * FROM {$form['spgfmc_tablename']} WHERE {$form['spgfmc_field_leadid']} = {$lead['id']}", ARRAY_A );
									$lead['gform_edit_id'] = $lead['id'];
									
								} elseif ( $form['spgfmc_delete_lead'] )
								{

								
									/**
									 * If the lead was deleted we use the already loaded data
									 * But we have to setup some lead values
									 */
									$data = $lead;
									$lead['created_by'] = 0;
									$lead['gform_edit_id'] = $data[$form['spgfmc_primarykey']];
									
								} else
								{
								

									/**
									 * We can't load any data
									 */
									unset ( $data );
									
								}
									
								if ( $data )
								{
								
									foreach ( (array)$form['fields'] AS $field )
									{
									
										switch( $field['type'] )
										{

											case 'address':
												if ( $field['spgfmc_fieldname_address1'] )
													$lead[$field['id'] . '.1'] = $data[$field['spgfmc_fieldname_address1']];
												if ( $field['spgfmc_fieldname_address1'] )
													$lead[$field['id'] . '.2'] = $data[$field['spgfmc_fieldname_address2']];
												if ( $field['spgfmc_fieldname_city'] )
													$lead[$field['id'] . '.3'] = $data[$field['spgfmc_fieldname_city']];
												if ( $field['spgfmc_fieldname_state'] )
													$lead[$field['id'] . '.4'] = $data[$field['spgfmc_fieldname_state']];
												if ( $field['spgfmc_fieldname_zip'] )
													$lead[$field['id'] . '.5'] = $data[$field['spgfmc_fieldname_zip']];
												if ( $field['spgfmc_fieldname_country'] )
													$lead[$field['id'] . '.6'] = $data[$field['spgfmc_fieldname_country']];
												break;

											case 'name':
												if ( $field['spgfmc_fieldname_firstname'] )
													$lead[$field['id'] . '.3'] = $data[$field['spgfmc_fieldname_firstname']];
												if ( $field['spgfmc_fieldname_lastname'] )
													$lead[$field['id'] . '.6'] = $data[$field['spgfmc_fieldname_lastname']];

											default:
												if ( $field['spgfmc_fieldname'] )
													$lead[$field['id']] = $data[$field['spgfmc_fieldname']];
												break;

										}
									
									
									}
								
								}
							
							} else
							{
							

								/**
								 * Retrieve the lead
								 */
								$lead = RGFormsModel::get_lead( $lead['id'] );
								$lead['gform_edit_id'] = $lead['id'];
							
							}
							 
							$i = 0;
							$html .= "				<tr>\n";


							/**
							 * Add a column to display the lead-id
							 */
							if ( $displaylead )
								$html .= "					<td scope=\"col\" class=\"col{$i}\">{$lead['id']}</td>\n";

						
							/** 
							 * Loop through the Fields
							 */
							foreach( $form['fields'] AS $field )
							{


								/** 
								 * Display 'adminOnly' fields only to form admins
								 */
								if ( !$field['adminOnly'] || GFCommon::current_user_can_any( 'gravityforms_edit_entries' ) )
								{


									/** 
									 * Only display fields that are checked at the field-settings
									 */
									if ( $field['spgfle_showinlist'] )
									{
								 
										$i++;
										unset ( $value, $display_value );
										$value = RGFormsModel::get_lead_field_value( $lead, $field );

										
										/**
										 * Only the value is stored, but we need to display
										 * the display-data for this value
										 */
										if ( $field['enableChoiceValue'] == '1' )
										{

											if ( !empty( $value ) )
											{

												unset ( $item, $items, $itemcount );
												foreach ( (array)$value as $single_value )
												{

													if ( !empty( $single_value ) )
													{

														foreach ( $field['choices'] as $choices )
														{

															if ( $choices['value'] == $single_value )
															{

																$items .= '<li>' . $choices['text'] . '</li>';
																$item = $choices['text'];
																$itemcount++;
																break;

															}

														}

													}

												}

												if ( $itemcount == 1 )
													$display_value = $item;
												elseif ( $itemcount > 0 )
													$display_value = "<ul class='bulleted'>$items</ul>";
												else
													$display_value = "";

											}

										} else
										{

											$display_value = GFCommon::get_lead_field_display( $field, $value, $lead["currency"] );

										}

										$html .= "					<td scope=\"col\" class=\"col{$i}\">{$display_value}</td>\n";
												
									}
								
								}
									
							}
							

							/**
							 * Display Button to the gfEdit Destination
							 */
							if ( $gfediturl || $gfdeleteurl)
							{

								$i++;
								$html .= "					<td scope=\"col\" class=\"col{$i}\">\n";


								/** 
								 * Check if the current user is the creator or an admin
								 * and display the edit and delete button if needed
								 */
								if ( ( !empty($lead['created_by'] ) && $lead['created_by'] == wp_get_current_user()->ID ) || GFCommon::current_user_can_any( 'gravityforms_edit_entries' ) )
								{
							
									$html .= "						<button class=\"button {$cssclass}\" onClick=\"SetHiddenFormSettings({$lead['gform_edit_id']}, 'update')\">" . __( "Edit", 'spgfle' ) . "</button>\n";
									
									/**
									 * Display the delete button
									 */
									if ( $form['spgfle_enabledelete'] )
										$html .= "						<button class=\"button {$cssclass}\" onClick=\"SetHiddenFormSettings({$lead['gform_edit_id']}, 'delete')\">" . __( "Delete", 'spgfle' ) . "</button>\n";
									
								}


								/**
								 * Display the view button
								 */
								if ( $form['spgfle_enableview'] )
									$html .= "						<button class=\"button {$cssclass}\" onClick=\"SetHiddenFormSettings({$lead['gform_edit_id']}, 'view')\">" . __( "View", 'spgfle' ) . "</button>\n";

								$html .= "					</td>\n"; 
									
							}
							
							$html .= "				</tr>\n";
						
						}
						
						$html .= "			</tbody>\n";
						$html .= "		</table>\n";


						/** 
						 * Check if the current user is the creator or an admin
						 * and display the addnew button
						 */
						if ( $form['spgfle_enableaddnew'] )
						{
						
							if ( GFCommon::current_user_can_any( 'gravityforms_edit_entries' ) )
							{
							
								$html .= "		<button class=\"button {$cssclass}\" onClick=\"SetHiddenFormSettings(0, 'addnew')\">" . __( "Addnew", 'spgfle' ) . "</button>\n";
									
							}
							
						}

						$html .= "	</form>\n";
						$html .= "	</div>\n";
						
					} else
					{
					
						$html = '<p>' . __( "You must be logged in.", 'spgfle' ) . '</p>';
						
					}
					
				}
				

				return ( $html );

			
			}
			
			
			
			/**
			 * Add a new checkbox to the advanced-settings of each supported field
			 * to select if the field should be displayed at the list	
			 */
			function spgfle_gform_field_advanced_settings( $position, $form_id )
			{

    
				if ( $position == -1 )
				{

					?>
					<li class="spgfle_setting field_setting">
						<input type="checkbox" id="spgfle_showinlist_value" onclick="SetFieldProperty('spgfle_showinlist', this.checked);" /> <?php _e( "Show Field in Entry List", 'spgfle' ); ?>
					</li>
					<?php
    
				}


			}

			
			
			/**
			 * Support the new advanced setting at the JS to supported field-types
			 */
			function spgfle_gform_editor_js()
			{

			
				?>
				<script type='text/javascript'>
					fieldSettings["text"] += ", .spgfle_setting";
					fieldSettings["textarea"] += ", .spgfle_setting";
					fieldSettings["select"] += ", .spgfle_setting";
					fieldSettings["multiselect"] += ", .spgfle_setting";
					fieldSettings["number"] += ", .spgfle_setting";
					fieldSettings["checkbox"] += ", .spgfle_setting";
					fieldSettings["radio"] += ", .spgfle_setting";
					fieldSettings["name"] += ", .spgfle_setting";
					fieldSettings["address"] += ", .spgfle_setting";
					fieldSettings["date"] += ", .spgfle_setting";
					fieldSettings["time"] += ", .spgfle_setting";
					fieldSettings["phone"] += ", .spgfle_setting";
					fieldSettings["website"] += ", .spgfle_setting";
					fieldSettings["email"] += ", .spgfle_setting";
					fieldSettings["fileupload"] += ", .spgfle_setting";
					fieldSettings["post_title"] += ", .spgfle_setting";
					fieldSettings["post_content"] += ", .spgfle_setting";
					fieldSettings["post_excerpt"] += ", .spgfle_setting";
					fieldSettings["post_category"] += ", .spgfle_setting";
					fieldSettings["post_tags"] += ", .spgfle_setting";
					fieldSettings["post_custom_field"] += ", .spgfle_setting";
					fieldSettings["product"] += ", .spgfle_setting";
					fieldSettings["quantity"] += ", .spgfle_setting";
					fieldSettings["option"] += ", .spgfle_setting";
					fieldSettings["shipping"] += ", .spgfle_setting";
					fieldSettings["total"] += ", .spgfle_setting";
					jQuery(document).bind("gform_load_field_settings", function(event, field, form) {
						jQuery("#spgfle_showinlist_value").attr("checked", field["spgfle_showinlist"] == true);
					});
				</script>
				<?php

				
			}
			
			
			
			/**
			 * Extend the default GravityForms form settings
			 */
			function spgfle_gform_form_settings( $settings, $form ) 
			{

    
				// display lead
				$spgfle_displaylead_checked = '';
				if ( rgar( $form, 'spgfle_displaylead' ) )
					$spgfle_displaylead_checked = 'checked="checked"';
				// require login
				$spgfle_requirelogin_checked = '';
				if ( rgar( $form, 'spgfle_requirelogin' ) )
					$spgfle_requirelogin_checked = 'checked="checked"';
				// show to all users
				$spgfle_showtoall_checked = '';
				if ( rgar( $form, 'spgfle_showtoall' ) )
					$spgfle_showtoall_checked = 'checked="checked"';
				// enable edit
				$spgfle_enableedit_checked = '';
				if ( rgar( $form, 'spgfle_enableedit' ) )
					$spgfle_enableedit_checked = 'checked="checked"';
				// enable view
				$spgfle_enableview_checked = '';
				if ( rgar( $form, 'spgfle_enableview' ) )
					$spgfle_enableview_checked = 'checked="checked"';
				// enable delete
				$spgfle_enabledelete_checked = '';
				if ( rgar( $form, 'spgfle_enabledelete' ) )
					$spgfle_enabledelete_checked = 'checked="checked"';
				// enable addnew
				$spgfle_enableaddnew_checked = '';
				if ( rgar( $form, 'spgfle_enableaddnew' ) )
					$spgfle_enableaddnew_checked = 'checked="checked"';
				// edit page
				$spgfle_gfediturl = rgar( $form, 'spgfle_gfediturl' );
				// css class
				$spgfle_cssclass = rgar( $form, 'spgfle_cssclass' );

				
				$settings['Gravity Forms - List & Edit Settings']['spgfle_settings'] = '
					<tr>
						<th><label for="spgfle_rows">' . __( "Number of Rows", 'spgfle' ) . '</label></th>
						<td><input type="text" value="' . rgar( $form, 'spgfle_rows' ) . '" name="spgfle_rows"></td>
					</tr>
					<tr>
						<th><label for="spgfle_cssclass">' . __( "CSS Class Name", 'spgfle' ) . '</label></th>
						<td><input type="text" value="' . rgar( $form, 'spgfle_cssclass' ) . '" name="spgfle_cssclass"></td>
					</tr>
					<tr id="spgfle_displaylead_setting_row">
						<th>' . __( "Display Lead-Id", 'spgfle' ) . '</th>
						<td>
							<input type="checkbox" id="spgfle_displaylead" name="spgfle_displaylead" value="true" ' . $spgfle_displaylead_checked . ' />
							<label for="spgfle_displaylead">' . __( "Display Lead-Id as first column at the Entry-List", 'spgfle' ) . '</label>
						</td>
					</tr>
					<tr id="spgfle_requirelogin_setting_row">
						<th>' . __( "Require user to be logged in", 'spgfle' ) . '</th>
						<td>
							<input type="checkbox" id="spgfle_requirelogin" name="spgfle_requirelogin" value="true" onclick="ToggleSpgfleRequireLogin();" ' . $spgfle_requirelogin_checked . ' />
							<label for="spgfle_requirelogin">' . __( "Require user to be logged in to view the list", 'spgfle' ) . '</label>
						</td>
					</tr>
					<tr id="spgfle_showtoall_setting_row">
						<th>' . __( "Show records to all users", 'spgfle' ) . '</th>
						<td>
							<input type="checkbox" name="spgfle_showtoall" value="true" ' . $spgfle_showtoall_checked . ' />
							<label for="spgfle_showtoall">' . __( "Show records to all users or only to the record creator", 'spgfle' ) . '</label>
						</td>
					</tr>
					<tr id="spgfle_enableedit_setting_row">
						<th>' . __( "Enable Edit-Mode", 'spgfle' ) . '</th>
						<td>
							<input type="checkbox" id="spgfle_enableedit" name="spgfle_enableedit" value="true" onclick="ToggleSpgfleEnableEdit();" ' . $spgfle_enableedit_checked . ' />
							<label for="spgfle_enableedit">' . __( "Enable edit mode for this form", 'spgfle' ) . '</label>
						</td>
					</tr>
					<tr id="spgfle_enableview_setting_row">
						<th>' . __( "Enable View Button", 'spgfle' ) . '</th>
						<td>
							<input type="checkbox" id="spgfle_enableview" name="spgfle_enableview" value="true" ' . $spgfle_enableview_checked . ' />
							<label for="spgfle_enableview">' . __( "Enable an 'View' Button for each entry", 'spgfle' ) . '</label>
						</td>
					</tr>
					<tr id="spgfle_enabledelete_setting_row">
						<th>' . __( "Enable Delete Button", 'spgfle' ) . '</th>
						<td>
							<input type="checkbox" id="spgfle_enabledelete" name="spgfle_enabledelete" value="true" ' . $spgfle_enabledelete_checked . ' />
							<label for="spgfle_enabledelete">' . __( "Enable an 'Delete' Button for each entry", 'spgfle' ) . '</label>
						</td>
					</tr>
					<tr id="spgfle_enableaddnew_setting_row">
						<th>' . __( "Enable AddNew Button", 'spgfle' ) . '</th>
						<td>
							<input type="checkbox" id="spgfle_enableaddnew" name="spgfle_enableaddnew" value="true" ' . $spgfle_enableaddnew_checked . ' />
							<label for="spgfle_enableaddnew">' . __( "Enable an 'AddNew' Button at the bottom of the list", 'spgfle' ) . '</label>
						</td>
					</tr>
					<tr id="spgfle_gfediturl_setting_row" style="display:none">
						<th><label for="spgfle_gfediturl">' . __( "Page to the gfEdit destination", 'spgfle' ) . '</label></th>
						<td>' . wp_dropdown_pages( array( 'name' => 'spgfle_gfediturl', 'echo' => 0, 'selected' => $spgfle_gfediturl ) )  .'</td>
					</tr>
					';
				


				/**
				 * Add some settings for tQuery support
				 */	
				if ( is_dir( dirname( __FILE__ ) . '/tquery' ) )
				{

					// tquery
					$spgfle_tquery_checked = '';
					if ( rgar( $form, 'spgfle_tquery' ) )
						$spgfle_tquery_checked = 'checked="checked"';
					// tquery search
					$spgfle_tquerysearch_checked = '';
					if ( rgar( $form, 'spgfle_tquerysearch' ) )
						$spgfle_tquerysearch_checked = 'checked="checked"';
					// tquery pagination
					$spgfle_tquerypagination_checked = '';
					if ( rgar( $form, 'spgfle_tquerypagination' ) )
						$spgfle_tquerypagination_checked = 'checked="checked"';


					$settings['Gravity Forms - List & Edit TQuery Support']['spgfle_settings'] .= '
						<tr id="spgfle_tquery_setting_row">
							<th>' . __("Enable tQuery", 'spgfle') . '</th>
							<td>
								<input type="checkbox" id="spgfle_tquery" name="spgfle_tquery" value="true" onclick="ToggleSpgfleTquery();" ' . $spgfle_tquery_checked . ' />
								<label for="spgfle_tquery">' . __("Enable tQuery support", 'spgfle') . '</label>
							</td>
						</tr>
						<tr id="spgfle_tquerysearch_setting_row">
							<th>' . __("Display tQuery search", 'spgfle') . '</th>
							<td>
								<input type="checkbox" id="spgfle_tquerysearch" name="spgfle_tquerysearch" value="true" ' . $spgfle_tquerysearch_checked . ' />
								<label for="spgfle_tquerysearch">' . __("Show the tquery search box", 'spgfle') . '</label>
							</td>
						</tr>
						<tr id="spgfle_tquerypagination_setting_row">
							<th>' . __("Display tQuery pagination", 'spgfle') . '</th>
							<td>
								<input type="checkbox" id="spgfle_tquery_pagination" name="spgfle_tquerypagination" value="true" ' . $spgfle_tquerypagination_checked . ' />
								<label for="spgfle_tquerypagination">' . __("Show the tquery pagination (the row setting will be used)", 'spgfle') . '</label>
							</td>
						</tr>
						';

				}


				/**
				 * Support for Sp-Gf-MySQL-Connect
				 * If we connected the record to a mysql-table and deleted the lead
				 * we could create a MySQL query to retrieve the needed data
				 */

				// SQL query
				$spgfle_sqlquery = rgar( $form, 'spgfle_sqlquery' );

					
				
				return ( $settings );

				
			}
 


			/**
			 * Save the extended settings
			 */
			function spgfle_gform_pre_form_settings_save( $form )  
			{


				$form['spgfle_enabledelete'] = rgpost( 'spgfle_enabledelete' );
				$form['spgfle_enableaddnew'] = rgpost( 'spgfle_enableaddnew' );
				$form['spgfle_requirelogin'] = rgpost( 'spgfle_requirelogin' );
				$form['spgfle_displaylead'] = rgpost( 'spgfle_displaylead' );
				$form['spgfle_enableview'] = rgpost( 'spgfle_enableview' );
				$form['spgfle_enableedit'] = rgpost( 'spgfle_enableedit' );
				$form['spgfle_showtoall'] = rgpost( 'spgfle_showtoall' );
				$form['spgfle_gfediturl'] = rgpost( 'spgfle_gfediturl' );
				$form['spgfle_cssclass'] = rgpost( 'spgfle_cssclass' );
				$form['spgfle_rows'] = rgpost( 'spgfle_rows' );

				$form['spgfle_tquery'] = rgpost('spgfle_tquery');
				$form['spgfle_tquerysearch'] = rgpost('spgfle_tquerysearch');
				$form['spgfle_tquerypagination'] = rgpost('spgfle_tquerypagination');


				/**
				 * Check some values
				 */
				if ( $form['spgfle_requirelogin'] )
					unset ( $form['spgfle_showtoall'] );


				return ( $form );


			}
		
			
			
			/**
			 * Extend the notification settings
			 */
			function spgfle_gform_notification_ui_settings( $ui_settings, $notification, $form )
			{

			
				$notificationType = rgar( $notification, 'spgfle_notification_type' );
				$optionArray = array(
								'all' => __( "on all events", 'spgfle' ),
								'addnew' => __( "only on addnew", 'spgfle' ),
								'delete' => __( "only on delete", 'spgfle' ),
								'update' => __( "only on update", 'spgfle' )
								);
								
				foreach ( $optionArray as $optionKey => $optionValue )
				{
				
					$selected = '';
					if ( $notificationType == $optionKey )
						$selected = ' selected="selected"';
						
					$option .= "<option value=\"{$optionKey}\" {$selected}>{$optionValue}</option>\n";
					
				}
								
				$ui_settings['my_custom_setting'] = '
					<tr>
						<th><label for="spgfle_notification_type">' . __( "send notification for", 'spgfle' ) . '</label></th>
						<td><select name="spgfle_notification_type" value="' . $notificationType . '">' . $option . '</select></td>
					</tr>';

				return ( $ui_settings );				

			
			}

			

			/**
			 * Save the notification settings
			 */
			function spgfle_gform_pre_notification_save( $notification, $form ) 
			{

    
				$notification['spgfle_notification_type'] = rgpost( 'spgfle_notification_type' );
				return ( $notification );


			}
			
			
			
			/**
			 * Only send the right notification
			 */
			function spgfle_gform_disable_notification( $is_disabled, $notification, $form, $entry )
			{

				
				if ( $form['spgfle_enableedit'] )
				{

					if ( $notification['spgfle_notification_type'] )
					{

				
						$is_disabled = true;


						/**
						 * Check wich notification must be sended
						 */
						switch ( $_REQUEST['gform_edit_mode'] )
						{


							case 'delete':
								if ( $notification['spgfle_notification_type'] == 'delete' || $notification['spgfle_notification_type'] == 'all'  )
									$is_disabled = false;
								break;

							case 'update':
								if ( $notification['spgfle_notification_type'] == 'update' || $notification['spgfle_notification_type'] == 'all'  )
									$is_disabled = false;
								break;

							default:
								if ( $notification['spgfle_notification_type'] == 'addnew' || $notification['spgfle_notification_type'] == 'all' )
									$is_disabled = false;
								break;

						}
				
					}			

				}

				return ( $is_disabled );

				
			}
			
			
			
		}

		// Instance class
		$SpGfListEdit= new SpGfListEdit();
		
	}

?>