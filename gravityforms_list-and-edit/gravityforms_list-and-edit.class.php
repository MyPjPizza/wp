<?php


	/**
 	 Class Name: SP Gravity Forms List & Edit
	 Class URI: http://specialpress.de/plugins/spgfle
	 Description: Make your Gravity Forms editable at the FrontEnd
	 Version: 2.3.0
	 Date: 2017/02/26
	 Author: Ralf Fuhrmann
	 Author URI: http://naranili.de
	 */

	
	
	class SpGfListEdit
	{


		/**
		 * construct
		 */
		function SpGfListEdit() 
		{
	
	
			/**
			 * add actions
			 */
			add_action( 'init', array( &$this, 'spgfle_init') );
			add_action( 'wp_enqueue_scripts', array( &$this, 'spgfle_wp_enqueue_scripts' ) );
	
		
			/**
			 * add filters
			 */
			add_filter( 'the_content', array( &$this, 'spgfle_the_content' ), 10, 1 );

		
			/**
			 * add GF actions
			 */
			add_action( 'gform_after_submission', array( &$this, 'spgfle_gform_after_submission' ), 10, 2 );
	
		
			/**
			 * add GF filters
			 */
			add_filter( 'gform_form_settings', array( &$this, 'spgfle_gform_form_settings' ), 10, 2 );
			add_filter( 'gform_pre_form_settings_save', array( &$this, 'spgfle_gform_pre_form_settings_save' ), 10, 1 );
			add_filter( 'gform_post_data', array( &$this, 'spgfle_gform_post_data' ), 10, 3 );
			add_filter( 'gform_entry_id_pre_save_lead', array( &$this, 'spgfle_gform_entry_id_pre_save_lead' ), 10, 2 );		
			add_filter( 'gform_pre_render', array( &$this, 'spgfle_gform_pre_render'), 10, 2 );
			add_filter( 'gform_confirmation_ui_settings', array( &$this, 'spgfle_gform_confirmation_ui_settings' ), 10, 3 );		
			add_filter( 'gform_notification_ui_settings', array( &$this, 'spgfle_gform_notification_ui_settings' ), 10, 3 );		
			add_filter( 'gform_pre_confirmation_save', array( &$this, 'spgfle_gform_pre_confirmation_save' ), 10, 2 );
			add_filter( 'gform_pre_notification_save', array( &$this, 'spgfle_gform_pre_notification_save' ), 10, 2 );
			add_filter( 'gform_disable_notification', array( &$this, 'spgfle_gform_disable_notification' ), 10, 4 );
			add_filter( 'gform_pre_submission_filter', array( &$this, 'spgfle_gform_pre_submission_filter' ), 10, 1 );
			
			
			/**
			 * if the gravityforms_wpdb-connect plugin isn't installed
			 * use the integrated function to replace default values
			 */
			if( !class_exists( 'SpGfWpdbConnect' ) )
				add_filter( 'gform_save_field_value', array( &$this, 'spgfle_gform_save_field_value' ), 10, 5 );

			
		}	
	


		/**
		 * init the plugin
		 */
		function spgfle_init() 
		{
	

			/**
			 * load the textdomain
			 */
			if( function_exists( 'load_plugin_textdomain' ) )
				load_plugin_textdomain( 'spgfle', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
			
			
		}



		/** 
		 * get the gravity forms shortcode and add some
		 * helpfull JS and CSS
		 */
		function spgfle_wp_enqueue_scripts()
		{

			
			global $post;
			if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'gravityform') ) 
			{

				/**
				 * enqueue the JS and CSS for readonly
				 */
				wp_enqueue_script( 'spgf-readonly', plugins_url( '/js/spgf_readonly.js' , __FILE__ ), array( 'jquery' ) );	
				wp_enqueue_style( 'spgf-readonly', plugins_url( '/css/spgf_readonly.css' , __FILE__ ) );	
				
			} elseif( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'gravitylist') ) 
			{
			
				/**
				 * add the wp_head action
				 */
				add_action( 'wp_head', array( &$this, 'spgfle_wp_head' ) );
				
			}
			

		}
	
	

		/**
		 * add some JS to the header
		 */
		function spgfle_wp_head()
		{

			?>
			<script type="text/javascript">
				function SetHiddenFormSettings(id, mode, source) {
					document.getElementById('gform_entry_id').value=id;
					document.getElementById('gform_entry_mode').value=mode;
					document.getElementById('gform_entry_source').value=source;
					document.forms["gravitylist"].submit();
				}	
			</script>
			<?php
		 
		}


		
		/**
		 * setup the current lead_id to update the entry
		 * instead of creating a new one
		 */
		function spgfle_gform_entry_id_pre_save_lead( $entry_id, $form )
		{

		
			if( intval( $entry_id ) > 0 )
				return( $entry_id );
	
			return( (int)$_REQUEST[ 'gform_entry_id' ] );

			
		}
	
	
	
		/**
		 * check the content if we have a Gravity Forms shortcode 
		 * and if we are in edit mode
		 */
		function spgfle_the_content( $content ) 
		{
		

			preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER );
			if( empty( $matches ) )
				return( $content );
			

			foreach( $matches as $shortcode ) 
			{	
		
				if( 'gravityform' === $shortcode[ 2 ] )
				{
			
					$attributes = shortcode_parse_atts( $shortcode[ 3 ] );
					SpGfListEdit::spgfle_parse_editmode( $attributes );	
					$content = do_shortcode( $content );
		
				}
				
			}


			return( $content );


		}

	
	
		/**
		 * check if we are in edit mode
		 */
		function spgfle_parse_editmode( $attributes ) 
		{

		
			/**
			 * if we haven't a form_id there is nothing do to
			 */
			$form_id = (int)$attributes[ 'id' ]; 
			if( !$form_id )
				return;
			$form = GFAPI::get_form( $form_id );
			
			
			/**
			 * check if the form is editable
			 */
			if( !$form[ 'spgfle_gfediturl' ] )
				return;


			/**
			 * get the entry_id to edit
			 */
			if( $attributes[ 'gform_entry_id' ] )
				$gform_entry_id = (int)$attributes[ 'gform_entry_id' ];
			else
				$gform_entry_id = (int)$_REQUEST[ 'gform_entry_id' ];

			
			/**
			 * get the entry_mode to edit
			 */
			if( $attributes[ 'gform_entry_mode' ] )
				$gform_entry_mode = $attributes[ 'gform_entry_mode' ];
			else
				$gform_entry_mode = $_REQUEST[ 'gform_entry_mode' ];

					
			/**
			 * get the entry_source to edit
			 */
			if( $attributes[ 'gform_entry_source' ] )
				$gform_entry_source = $attributes[ 'gform_entry_source' ];
			else
				$gform_entry_source = $_REQUEST[ 'gform_entry_source' ]; 

			
			/**
			 * apply filters to catch the data from 
			 * something else
			 */
			$gform_entry_id = apply_filters( 'spgfle_gform_entry_id', $gform_entry_id, $form );
			$gform_entry_mode = apply_filters( 'spgfle_gform_entry_mode', $gform_entry_mode, $form );
			$gform_entry_source = apply_filters( 'spgfle_gform_entry_source', $gform_entry_source, $form );
					
					
			/**
			 * if we haven't a entry_id there is nothing to do
			 */
			if( !$gform_entry_id )
				return;
			$entry = GFAPI::get_entry( $gform_entry_id );
			
			
			/**
			 * return if there isn't an entry
			 */
			if( !is_array( $entry ) )
				return;
			
			
			
			$_REQUEST[ 'gform_entry_id' ] = $gform_entry_id;
			$_REQUEST[ 'gform_entry_mode' ] = $gform_entry_mode;
			$_REQUEST[ 'gform_entry_source' ] = $gform_entry_source;

			
			/**
			 * simulate the form input
			 */
			SpGfListEdit::simulate_post( $entry, $form );
			
			add_filter( 'gform_submit_button', array( 'SpGfListEdit', 'spgfle_gform_submit_button' ), 100, 2 );
			
		
		}



		/**
		 * add a hidden field with the lead_id
		 * and the plugin mode
		 */
		function spgfle_gform_submit_button( $button_input, $form ) 
		{

		
			/**
			 * if the form is called from this plugin
			 */
			if( isset( $_REQUEST[ 'gform_entry_mode' ] ) )
			{

				switch( $_REQUEST[ 'gform_entry_mode' ] )
				{

					case 'addnew':
						break;
					case 'change':
						$button_input = '<input type="submit" class="gform_button button" id="gform_submit_button_' . $form[ 'id' ] . '" value="' . __( "Change", 'spgfle') . '"/>';
						break;
					case 'delete':
						$button_input = '<input type="submit" class="gform_button button" id="gform_submit_button_' . $form[ 'id' ] . '" value="' . __( "Delete", 'spgfle') . '"/>';
						break;
					default:
						$button_input = '<input type="reset" class="gform_button button" id="gform_submit_button_' . $form[ 'id' ] . '" value="' . __( "Cancel", 'spgfle') . '"/>';
						break;

				}


				$button_input .= "<input type=\"hidden\" class=\"gform_hidden\" name=\"gform_entry_id\" value=\"{$_REQUEST[ 'gform_entry_id' ]}\" />";
				$button_input .= "<input type=\"hidden\" class=\"gform_hidden\" name=\"gform_entry_mode\" value=\"{$_REQUEST[ 'gform_entry_mode' ]}\" />";
				$button_input .= "<input type=\"hidden\" class=\"gform_hidden\" name=\"gform_entry_source\" value=\"{$_REQUEST[ 'gform_entry_source' ]}\" />";


				/**
				 * Check if we have post fields
				 */
				if( GFCOmmon::has_post_field( $form[ 'fields' ] ) )
				{

					$entry = GFAPI::get_entry( (int)$_REQUEST[ 'gform_entry_id' ] );		
					$post = get_post( intval( $entry[ 'post_id' ] ) );
					if( $post )
					{	
			
						$button_input .= "<input type=\"hidden\" class=\"gform_hidden\" name=\"gform_post_id\" value=\"{$post->ID}\" />";
						$button_input .= "<input type=\"hidden\" class=\"gform_hidden\" name=\"gform_post_status\" value=\"{$post->post_status}\" />";
			
					}
			
				}

			}

		
			return( $button_input );

	
		}

	
	
		/**
		 * retrieve the entry values and fill
		 * the $_POST var with the right values
		 */
		function simulate_post( $entry, $form ) 
		{
		

			/**
			 * only fill the data once a time
			 */
			if( $_POST[ 'is_submit_' . $form[ 'id' ] ] )
				return;
		
		
			/**
			 * retrieve and format the values for all input fields
			 */
			foreach( $entry as $key => $value ) 
			{
	
	
				$input = 'input_' . str_replace( '.', '_', strval( $key ) );
				$field = RGFormsModel::get_field( $form, $key );
		
		
				/**
				 * update the input data for adminOnly fields only if we are an admin
				 */
				if( $field[ 'adminOnly' ] && !GFCommon::current_user_can_any( 'gravityforms_edit_entries' ) ) 
					continue;
		
		
				switch( $field[ 'type' ] )
				{
			
					case 'file':
					case 'post_image':
						/**
						 * we don't support this field-types
						 */
						break;
						
					case 'date':
						/**
						 * if we get a blank date-value from MySQL
						 * we have to make it empty
						 */
						if( $value == '0000-00-00' )
							$value = '';
						$_POST[ $input ] = GFCommon::get_lead_field_display( $field, $value, $entry[ 'currency' ] );
						break;

					case 'number':
						/**
						 * if we get a zero value from MySQL
						 * we have to make it empty
						 */
						if( $value == 0 )
							$value = '';
						$_POST[ $input ] = GFCommon::get_lead_field_display( $field, $value, $entry[ 'currency' ] );
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
				
								$_POST[ $input ][ $i ] = $colValue;
								$i++;
			
							}

						}
						break;

					case 'post_category':
						/**
						 * GF stored this as {category_name}:{category_id}
						 */
						$category = explode( ':' , $value );
						$_POST[ $input ] = $category[ 1 ];
						break;

					case 'post_custom_field':
						/**
						 * GF stored custom-post list fields a little bit different
						 * from normal list-fields.
						 */
						if( $field[ 'inputType' ] == 'list' )
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
				
									$_POST[ $input ][ $i ] = $colValue;
									$i++;
			
								}

							}

						} else
						{

							$_POST[ $input ] = $value;

						}
						break;

				
					case 'total':
						/**
						 * delete cached data, so the total can be recalculated
						 */
						gform_delete_meta( $entry[ 'id' ], 'gform_product_info_1_1' );
						gform_delete_meta( $entry[ 'id' ], 'gform_product_info_1_' );
						gform_delete_meta( $entry[ 'id' ], 'gform_product_info__' );
						break;
				 
					default:
						$_POST[ $input ] = $value;
						break;
			
				}
		
			}
			

			$_POST[ 'gform_target_page_number_' . $form[ 'id' ] ] = "'" . GFFormDisplay::get_max_page_number( $form ) . "'";
			$_POST[ 'gform_source_page_number_' . $form[ 'id' ] ] = '1';
			$_POST[ 'is_submit_' . $form[ 'id' ] ] = '1';
			$_POST[ 'gform_submit' ] = $form[ 'id' ];
			$_POST[ 'gform_unique_id' ] = RGFormsModel::get_form_unique_id( $form[ 'id' ] );
			$_POST[ 'gform_entry_id' ] = $entry[ 'id' ];

			
		}	



		/**
		 * check if we need to update the post
		 */
		function spgfle_gform_post_data( $post_data, $form, $entry )
		{
	
	
			$post_id = intval( $_REQUEST[ 'gform_post_id' ] );
			if( $post_id ) {
		
				$post_data[ 'ID' ] = $post_id;
			
				/**
				 * all stored custom fields must be deleted
				 * in case GF will save them more than once
				 */
				foreach( $form[ 'fields' ] as $field )
				{
			
					if( $field[ 'type' ] == 'post_custom_field' )
						delete_post_meta( $post_id, $field[ 'postCustomFieldName' ] );
			
			
				}
			 
			
			}
		

			return( $post_data );

	
		}
	
	
	
		/**
		 * check if we need to delete the entry or
		 * if we need to update the post_status
		 */
		function spgfle_gform_after_submission( $entry, $form )
		{
	
		
			if( $_REQUEST[ 'gform_entry_mode' ] == 'delete' )
			{

		
				$entry_id = $entry[ 'id' ];
				if( $entry_id )
					GFAPI::delete_entry( $entry_id );


			} else
			{	

				$post_id = intval( $_REQUEST[ 'gform_post_id' ] );
				$post_status = $_REQUEST[ 'gform_post_status' ];
				if( $post_id )
				{	
		
		
					/**
					 * get the post and setup the old status
					 */
					$post = get_post( $post_id );
					if( $post )
					{

							$post->post_status = $post_status;
						wp_update_post( $post );
		
					}
		
				}	

			}

	
		}



		/**
		 * check if we have to add the readonly class to the fields
		 */
		function spgfle_gform_pre_render( $form )
		{


			if( $_REQUEST[ 'gform_entry_mode' ] == 'delete' )
			{

				foreach( $form[ 'fields' ] as $key => $field )
					$form[ 'fields' ][ $key ][ 'cssClass' ] .= " readonly";
		

			}


			return( $form );


		}
	
	
	
		/**
		 * replace the placeholder at a field with
		 * the right value
		 */
		function spgfle_gform_save_field_value( $value, $lead, $field, $form, $input_id )
		{
	
	
			$value = str_replace( '{entry_id}', $lead[ 'id' ], $value );
			
			return( $value );
	
	
		}
	

	
		/**
		 * extend the default GravityForms form settings
		 */
		function spgfle_gform_form_settings( $settings, $form ) 
		{

    
			$options_array = array( 
				'' => __( "disabled", 'spgfle' ),
				'icon' => __( "Icon button", 'spgfle' ),
				'text' => __( "Text button", 'spgfle' )
				);
		
			
			/* enable addnew */
			$options = '';
			$spgfle_addnew = rgar( $form, 'spgfle_addnew' );
			foreach( $options_array AS $key => $value )
			{
		
				$selected = '';
				if( $spgfle_addnew == $key )
					$selected = ' selected="selected"';
		
				$options .= "<option value=\"{$key}\" {$selected}>{$value}</option>\n";
		
			}
			
			$settings[ 'List & Edit Settings' ][ 'spgfle_settings' ] .= '
				<tr id="spgfle_addnew_setting_row">
					<th>' . __( "Enable AddNew Button", 'spgfle' ) . '</th>
					<td>
						<select id="spgfle_addnew" name="spgfle_addnew">' . $options . '</select>
						<label for="spgfle_addnew">' . __( "Enable a text or an icon button to add a record.", 'spgfle' ) . '</label>
					</td>
				</tr>';	
			
			
			/* enable change */
			$options = '';
			$spgfle_change = rgar( $form, 'spgfle_change' );
			foreach( $options_array AS $key => $value )
			{
		
				$selected = '';
				if( $spgfle_change == $key )
					$selected = ' selected="selected"';
		
				$options .= "<option value=\"{$key}\" {$selected}>{$value}</option>\n";
		
			}
			
			$settings[ 'List & Edit Settings' ][ 'spgfle_settings' ] .= '
				<tr id="spgfle_change_setting_row">
					<th>' . __( "Enable Change Button", 'spgfle' ) . '</th>
					<td>
						<select id="spgfle_change" name="spgfle_change">' . $options . '</select>
						<label for="spgfle_change">' . __( "Enable a text or an icon button to change a record.", 'spgfle' ) . '</label>
					</td>
				</tr>';	
		
			
			/* enable delete */
			$options = '';
			$spgfle_delete = rgar( $form, 'spgfle_delete' );
			foreach( $options_array AS $key => $value )
			{
		
				$selected = '';
				if( $spgfle_delete == $key )
					$selected = ' selected="selected"';
		
				$options .= "<option value=\"{$key}\" {$selected}>{$value}</option>\n";
		
			}
			
			$settings[ 'List & Edit Settings' ][ 'spgfle_settings' ] .= '
				<tr id="spgfle_delete_setting_row">
					<th>' . __( "Enable Delete Button", 'spgfle' ) . '</th>
					<td>
						<select id="spgfle_delete" name="spgfle_delete">' . $options . '</select>
						<label for="spgfle_delete">' . __( "Enable a text or an icon button to delete a record.", 'spgfle' ) . '</label>
					</td>
				</tr>';	
			
			
			/* editable by user */
			$options = '';
			$spgfle_workableby = rgar( $form, 'spgfle_workableby' );
			$spgfle_workableby_array = array( 
					0 => __( "everyone", 'spgfle' ),
					1 => __( "logged in", 'spgfle' ),
					2 => __( "entry creator", 'spgfle' ),
					3 => __( "only to the admin", 'spgfle' )
					);
							
			foreach( $spgfle_workableby_array AS $key => $value )
			{

				$spgfle_workableby_selected = '';
				if( $spgfle_workableby == $key )					
					$spgfle_workableby_selected = 'selected="selected"';
				$options .= "	<option value=\"{$key}\" {$spgfle_workableby_selected}>{$value}</option>\n";
								
			}					


			$settings[ 'List & Edit Settings' ][ 'spgfle_settings' ] .= '
				<tr id="spgfle_workableby_setting_row">
					<th>' . __( "Records workable by ", 'spgfle' ) . '</th>
					<td>
						<select name="spgfle_workableby">' . $options . '</select>
						<label for="spgfle_workableby">' . __( "From wich users to entries should be workable", 'spgfle' ) . '</label>
					</td>
				</tr>';
				
				
			
			/* edit url */
			$spgfle_gfediturl = rgar( $form, 'spgfle_gfediturl' );
			$settings[ 'List & Edit Settings' ][ 'spgfle_settings' ] .= '
				<tr id="spgfle_gfediturl_setting_row">
					<th><label for="spgfle_gfediturl">' . __( "Page to the gfEdit destination", 'spgfle' ) . '</label></th>
					<td>' . wp_dropdown_pages( array( 'name' => 'spgfle_gfediturl', 'echo' => 0, 'selected' => $spgfle_gfediturl, 'show_option_none' => __( "-Not Editable-", 'spgfle' ) ) )  .'</td>
				</tr>
				';
		


			return( $settings );

		
		}
 


		/**
		 * Save the extended settings
		 */
		function spgfle_gform_pre_form_settings_save( $form )  
		{


			$form[ 'spgfle_workableby' ] = rgpost( 'spgfle_workableby' );
			$form[ 'spgfle_gfediturl' ] = rgpost( 'spgfle_gfediturl' );
			$form[ 'spgfle_addnew' ] = rgpost( 'spgfle_addnew' );
			$form[ 'spgfle_change' ] = rgpost( 'spgfle_change' );
			$form[ 'spgfle_delete' ] = rgpost( 'spgfle_delete' );

			return( $form );


		}
		
	
	
		/**
		 * extend the confirmation settings
		 */
		function spgfle_gform_confirmation_ui_settings( $ui_settings, $confirmation, $form )
		{

		
			$confirmations = $form[ 'confirmations' ];
			
			
			/**
			 * GF need at least one confirmation
			 */
			if( count( $confirmations ) <= 1 )
				return( $ui_settings );
	
	
			$confirmationType = rgar( $confirmation, 'spgfle_confirmation_type' );
			$optionArray = array(
					'all' => __( "on all events", 'spgfle' ),
					'addnew' => __( "only on addnew", 'spgfle' ),
					'change' => __( "only on change", 'spgfle' ),
					'delete' => __( "only on delete", 'spgfle' )
			);
				
			foreach( $optionArray as $optionKey => $optionValue )
			{
		
				$selected = '';
				if( $confirmationType == $optionKey )
					$selected = ' selected="selected"';
		
				$option .= "<option value=\"{$optionKey}\" {$selected}>{$optionValue}</option>\n";
			
			}
				
				
			$ui_settings[ 'spgfle_confirmation_setting' ] = '
				<tr>
					<th><label for="spgfle_confirmation_type">' . __( "send confirmation", 'spgfle' ) . '</label></th>
					<td><select name="spgfle_confirmation_type" value="' . $confirmationType . '">' . $option . '</select></td>
				</tr>';

			return( $ui_settings );		

	
		}

	
		/**
		 * extend the notification settings
		 */
		function spgfle_gform_notification_ui_settings( $ui_settings, $notification, $form )
		{

	
			$notificationType = rgar( $notification, 'spgfle_notification_type' );
			$optionArray = array(
					'all' => __( "on all events", 'spgfle' ),
					'addnew' => __( "only on addnew", 'spgfle' ),
					'change' => __( "only on change", 'spgfle' ),
					'delete' => __( "only on delete", 'spgfle' ),
			);
				
			foreach( $optionArray as $optionKey => $optionValue )
			{
		
				$selected = '';
				if( $notificationType == $optionKey )
					$selected = ' selected="selected"';
		
				$option .= "<option value=\"{$optionKey}\" {$selected}>{$optionValue}</option>\n";
			
			}
				
			$ui_settings[ 'spgfle_notification_setting' ] = '
				<tr>
					<th><label for="spgfle_notification_type">' . __( "send notification", 'spgfle' ) . '</label></th>
					<td><select name="spgfle_notification_type" value="' . $notificationType . '">' . $option . '</select></td>
				</tr>';

			return( $ui_settings );		

	
		}

	

		/**
		 * save the confirmation settings
		 */
		function spgfle_gform_pre_confirmation_save( $confirmation, $form ) 
		{

    
			$confirmation[ 'spgfle_confirmation_type' ] = rgpost( 'spgfle_confirmation_type' );
			return( $confirmation );


		}



		/**
		 * save the notification settings
		 */
		function spgfle_gform_pre_notification_save( $notification, $form ) 
		{

    
			$notification[ 'spgfle_notification_type' ] = rgpost( 'spgfle_notification_type' );
			return( $notification );


		}
	
	
	
		/**
		 * only do the right confirmation
		 * this is a little bit tricky. GF doesn't support a real hook for this
		 * so we disable all confirmations that doesn't match the right action
		 * and let GF do the rest
		 */
		function spgfle_gform_pre_submission_filter( $form )
		{
	
	
			$confirmations = $form[ 'confirmations' ];
			
			
			/**
			 * GF need at least one confirmation
			 */
			if( count( $confirmations ) <= 1 )
				return( $form );
			
			
			/**
			 * loop thru the confirmation array
			 */
			foreach( (array)$confirmations AS $key => $confirmation ) 
			{
		
		
				/**
				 * only work on activ confirmations
				 */
				if ( isset( $confirmation[ 'isActive' ] ) && ! $confirmation[ 'isActive' ] ) 
					continue;
		
		
				/**
				 * nothing special to do
				 */
				if( !$confirmation[ 'spgfle_confirmation_type' ] || $confirmation[ 'spgfle_confirmation_type' ] == 'all' )
					continue;
			

				/**
				 * if we haven't the right type, set the confirmation to inactiv
				 */
				if( $_REQUEST[ 'gform_entry_mode' ] != $confirmation[ 'spgfle_confirmation_type' ] )
				{
			
					$confirmation[ 'isActive' ] = false;
					$form[ 'confirmations' ][ $key ] = $confirmation;
			
			
				}
		
			}
			
			return( $form );
		
		}



		/**
		 * only send the right notification
		 */
		function spgfle_gform_disable_notification( $is_disabled, $notification, $form, $entry )
		{

		
			/**
			 * nothing special to do
			 */
			if( !$notification[ 'spgfle_notification_type' ] || $notification[ 'spgfle_notification_type' ] == 'all' )
				return( $is_disabled );


			/**
			 * if we have the right type, send the notification
			 */
			if( $_REQUEST[ 'gform_entry_mode' ] == $notification[ 'spgfle_notification_type' ] )
				return( false );
			else
				return( true );
			
		
		
		}
	
	
	
	}

	/* instance class */
	$SpGfListEdit= new SpGfListEdit();
		

?>