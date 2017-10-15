<?php



	/**
 	 Class Name: SP Gravity Forms WPDB Connect
	 Class URI: http://specialpress.de/plugins/spgfwpdb
	 Description: Connect Gravity Forms to the WPDB MySQL Database
	 Version: 3.1.0
	 Date: 2017/03/01
	 Author: Ralf Fuhrmann
	 Author URI: http://naranili.de
	 */



	class SpGfWpdbConnect extends GFFeedAddOn 
	{

	
		protected $_version = '3.1.0';
		protected $_min_gravityforms_version = '2.0.0';
		protected $_slug = 'wpdb-connect';
		protected $_path = 'gravityforms_wpdb-connect/gravityforms_wpdb-connect.php';
		protected $_full_path = __FILE__;
		protected $_title = 'Gravity Forms WPDB Connect';
		protected $_short_title = 'GF WPDB Connect';

		private static $_instance = null;



		/**
		 * get an instance of this class.
		 *
		 * @return GFSimpleAddOn
		 */

		public static function get_instance() 
		{
		
			
			if ( self::$_instance == null ) 
				self::$_instance = new SpGfWpdbConnect();
		

			return( self::$_instance );


		}	



		/**
		 * plugin starting point
		 * handles hooks, loading of language files and PayPal delayed payment support
		 */

		public function init() 
		{

		
			parent::init();


			/**
			 * load the textdomain
			 */

			if( function_exists('load_plugin_textdomain') )
				load_plugin_textdomain( 'spgfwpdb', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');


			/**
			 * add GF actions
			 */

			add_action( 'gform_field_advanced_settings', array( &$this, 'spgfwpdb_gform_field_advanced_settings' ), 10, 2 );				
			add_action( 'gform_editor_js', array( &$this, 'spgfwpdb_gform_editor_js' ), 10 );
			add_action( 'gform_post_add_entry', array( &$this, 'spgfwpdb_gform_post_add_entry' ), 10, 2 );
			add_action( 'gform_after_update_entry', array( &$this, 'spgfwpdb_gform_after_update_entry' ), 10, 3 );	
			add_action( 'gform_post_update_entry', array( &$this, 'spgfwpdb_gform_post_update_entry' ), 10, 2 );
			add_action( 'gform_delete_lead', array( &$this, 'spgfwpdb_gform_delete_lead' ), 10, 1 );
			add_action( 'gform_delete_entries', array( &$this, 'spgfwpdb_gform_delete_entries' ), 10, 2 );
		
		
			/**
			 * add GF filters
			 */

			add_filter( 'gform_save_field_value', array( &$this, 'spgfwpdb_gform_save_field_value' ), 10, 5 );
			add_filter( 'gform_custom_merge_tags', array( &$this, 'spgfwpdb_gform_custom_merge_tags' ), 10, 3 );
			add_filter( 'gform_pre_render', array( &$this, 'spgfwpdb_gform_pre_render' ), 99, 3 );		
			add_filter( 'gform_field_validation', array( &$this, 'spgfwpdb_gform_field_validation' ), 10, 4 );


		}



		/**
		 * process the feed 
		 *
		 * @param array $feed the feed object to be processed
		 * @param array $entry the entry object currently being processed
		 * @param array $form the form object currently being processed
		 *
		 * @return bool|void
		 */

		public function process_feed( $feed, $entry, $form ) 
		{
		


			/**
			 * process the used datafields
			 */

			foreach( $feed[ 'meta' ][ 'wpdbTableFields' ] AS $field )
			{


				/**
				 * key = name of the mysql field
				 * value = array-key of the gf entry
				 */

				$saveFieldTypes[ $field[ 'key' ] ] = self::spgfwpdb_get_field_type( $feed[ 'meta' ][ 'wpdbTable' ], $field[ 'key' ] );
				$saveFieldValues[ $field[ 'key' ] ] = $this->get_field_value( $form, $entry, $field[ 'value' ] );


			}



			/**
			 * insert the record into the WPDB table
			 */

			global $wpdb;

			$wpdb->insert( $feed[ 'meta' ][ 'wpdbTable' ], $saveFieldValues, $saveFieldTypes );		

			$insertedId = $wpdb->insert_id;



			/**
			 * return the insert_id if required
			 */
			
			if( $feed[ 'meta' ][ 'wpdbPrimaryKey' ][0][ 'value' ] )
			{


				if( $entry[ $feed[ 'meta' ][ 'wpdbPrimaryKey' ][0][ 'value' ] ] == '{insert:id}' ) 
				{

					
					$entry[ $feed[ 'meta' ][ 'wpdbPrimaryKey' ][0][ 'value' ] ] = $insertedId;

					GFAPI::update_entry( $entry );


				}

			}


		}



		/**
		 * process the feed to update the database
		 *
		 * @param array $feed the feed object to be processed
		 * @param array $entry the entry object currently being processed
		 * @param array $form the form object currently being processed
		 *
		 * @return bool|void
		 */

		public function process_feed_update( $feed, $entry, $form ) 
		{
		

			/**
			 * process the used primarykeys
			 */

			$is_primaryKey = FALSE;
			foreach( $feed[ 'meta' ][ 'wpdbPrimaryKey' ] AS $field )
			{


				/**
				 * key = name of the mysql field
				 * value = array-key of the gf entry
				 */

				$savePrimaryTypes[ $field[ 'key' ] ] = self::spgfwpdb_get_field_type( $feed[ 'meta' ][ 'wpdbTable' ], $field[ 'key' ] );
				$savePrimaryValues[ $field[ 'key' ] ] = $entry[ $field[ 'value' ] ];
				$is_primaryKey = TRUE;


			}


			/**
			 * without an primary key it's not possible to update the record
			 */

			if( !$is_primaryKey )
				return;



			/**
			 * process the used datafields
			 */

			foreach( $feed[ 'meta' ][ 'wpdbTableFields' ] AS $field )
			{


				/**
				 * key = name of the mysql field
				 * value = array-key of the gf entry
				 */

				$saveFieldTypes[ $field[ 'key' ] ] = self::spgfwpdb_get_field_type( $feed[ 'meta' ][ 'wpdbTable' ], $field[ 'key' ] );
				$saveFieldValues[ $field[ 'key' ] ] = $entry[ $field[ 'value' ] ];


			}


			/**
			 * insert the record into the WPDB table
			 */

			global $wpdb;

			$wpdb->update( $feed[ 'meta' ][ 'wpdbTable' ], $saveFieldValues, $savePrimaryValues, $saveFieldTypes, $savePrimaryTypes );		


		}



		/**
		 * process the feed to delete the database
		 *
		 * @param array $feed the feed object to be processed
		 * @param array $entry the entry object currently being processed
		 * @param array $form the form object currently being processed
		 *
		 * @return bool|void
		 */

		public function process_feed_delete( $feed, $entry, $form ) 
		{
		

			/**
			 * process the used primarykeys
			 */

			$is_primaryKey = FALSE;
			foreach( $feed[ 'meta' ][ 'wpdbPrimaryKey' ] AS $field )
			{


				/**
				 * key = name of the mysql field
				 * value = array-key of the gf entry
				 */

				$savePrimaryTypes[ $field[ 'key' ] ] = self::spgfwpdb_get_field_type( $feed[ 'meta' ][ 'wpdbTable' ], $field[ 'key' ] );
				$savePrimaryValues[ $field[ 'key' ] ] = $entry[ $field[ 'value' ] ];
				$is_primaryKey = TRUE;


			}


			/**
			 * without an primary key it's not possible to delete the record
			 */

			if( !$is_primaryKey )
				return;



			/**
			 * insert the record into the WPDB table
			 */

			global $wpdb;

			$wpdb->delete( $feed[ 'meta' ][ 'wpdbTable' ], $savePrimaryValues, $savePrimaryTypes );		


		}




		/**
		 * --------------------------------------------------------------------------------
		 * filters and actions to extend the GF functions
		 * --------------------------------------------------------------------------------
		 */




		/**
		 * return an array of the columns to display
		 *
		 * @return array
		 */

		public function feed_list_columns() 
		{
    
		
			return( array(
				'feedName' => __( 'Name', 'spgfwpdb' ),
				'wpdbTable'   => __( 'WPDB Tablename', 'spgfwpdb' )
			) );


		}



		/**
		 * configures the settings which should be rendered on the feed edit page in the form settings
		 *
		 * @return array
		 */

		public function feed_settings_fields() 
		{
		

			/**
			 * retrieve the current feed meta
			 */

			if( intval( rgget( 'fid' ) ) )
				$feed = $this->get_feed( rgget( 'fid' ) );


			$settingFields = array();


			$settingFields[ 'default' ] = array(
				
				'title'  => esc_html__( 'WPDB Connect Feed Settings', 'spgfwpdb' ),
				'description' => '',
				'fields' => array(

						array(
							'label'   	=> esc_html__( 'Feed name', 'spgfwpdb' ),
							'type'   	=> 'text',
							'name'    	=> 'feedName',
							'class'		=> 'medium',
							'tooltip' 	=> esc_html__( 'Enter a name for the feed', 'spgfwpdb' ),
							'required'	=> true,
						),

						array(
							'name'      => 'wpdbTable',
							'type'      => 'select',
							'label'     => esc_html__( 'WPDB Table Name', 'spgfwpdb' ),
							'tooltip'	=> esc_html__( 'Select the WPDB Table name', 'spgfwpdb' ),
							'choices'   => self::spgfwpdb_get_table_names(),
							'required'  => true,
						),

					),

				);

		
			/**
			 * display the fields only if we have a table
			 */

			if( !empty( $feed[ 'meta' ][ 'wpdbTable' ] ) )
			{

				$settingFields[ 'fieldnames' ] = array(
	
					'title'       => esc_html__( 'Field Names', 'gravityformsuserregistration' ),
					'description' => '',
					'dependency'  => array(
						'field'   => 'wpdbTable',
						'values'  => '_notempty_'
					),	
					'fields'      => array(
						array(	
							'name'      => 'wpdbTableFields',
							'label'     => '',
							'type'      => 'dynamic_field_map',
							'disable_custom' => TRUE,
							'field_map' => self::spgfwpdb_get_field_names( $feed[ 'meta' ][ 'wpdbTable' ] ),
							'class'     => 'medium'
						),

					),

				);

				$settingFields[ 'primarykey' ] = array(
	
					'title'       => esc_html__( 'Primary Key', 'gravityformsuserregistration' ),
					'description' => '',
					'dependency'  => array(
						'field'   => 'wpdbTable',
						'values'  => '_notempty_'
					),	
					'fields'      => array(
						array(	
							'name'      => 'wpdbPrimaryKey',
							'label'     => '',
							'type'      => 'dynamic_field_map',
							'disable_custom' => TRUE,
							'field_map' => self::spgfwpdb_get_primary_keys( $feed[ 'meta' ][ 'wpdbTable' ] ),
							'class'     => 'medium'
						),

					),

				);

			}

				
			return( array_values( $settingFields ) );


		}



		/**
		 * custom function to create the field-map choices that will exclude
		 * the mutlipleFiles and the list field
		 *
		 * @param $form_id int the id of the current_form
		 * @param $field_type string type of the field
		 * @param $explude_field_types array field to be exluded
		 *
		 * @return array
		 */

		public static function get_field_map_choices( $form_id, $field_type = null, $exclude_field_types = null ) 
		{


			$choices = parent::get_field_map_choices( $form_id, $field_type, array( 'list', 'multipleFiles' ) );

			return( $choices );
	

		}




		/**
		 * --------------------------------------------------------------------------------
		 * filters and actions to extend the GF functions
		 * --------------------------------------------------------------------------------
		 */



		/**
		 * replace the placeholder at a field with the right value
		 *
		 * @param $value mixed the field value
		 * @param $lead object the current entry
		 * @param $field object the current field
		 * @param $form object the current form
		 * @param $input_id string the id of the input
		 *
		 * @return array
		 */

		function spgfwpdb_gform_save_field_value( $value, $lead, $field, $form, $input_id )
		{
			
			
			$value = str_replace( '{user:id}', wp_get_current_user()->ID, $value );
			$value = str_replace( '{entry:id}', $lead[ 'id' ], $value );
				
			return( $value );
			
			
		}


				
		/**
		 * add some nice and new merge tags to fill with needed data
		 *
		 * @param $form_id int the form id
		 * @param $fields object the fields
		 * @param $element_id int the id of the element
		 *
		 * @return array
		 */

		function spgfwpdb_gform_custom_merge_tags( $form_id, $fields, $element_id )
		{			
				

			$custom_group[] = array( 'tag' => '{insert:id}', 'label' => __( 'Insert ID', 'spgfwpdb' ) );
			$custom_group[] = array( 'tag' => '{entry:id}', 'label' => __( 'Entry ID', 'spgfwpdb' ) );
			$custom_group[] = array( 'tag' => '{user:id}', 'label' => __( 'User ID', 'spgfwpdb' ) );

			return( $custom_group );

					
		}



		/**
		 * process the feeds if an entry was added with the GFAPI
		 *
		 * @param $entry object the current entry
		 * @param $form object the current form
		 */

		public function spgfwpdb_gform_post_add_entry( $entry, $form )
		{


			/**
			 * loop thru and process the feeds
			 */

			$feeds = GFAPI::get_feeds( NULL, $entry[ 'form_id' ], $this->_slug );
			foreach( (array)$feeds AS $feed )
				self::process_feed( $feed, $entry, $form );


		}



		/**
		 * process the feeds after the entry was changed with the GFAPI
		 *
		 * @param $entry array the current entry		 
		 * @param $original_entry array the entry before the changes
		 */

		function spgfwpdb_gform_post_update_entry( $form, $entry_id, $original_entry )
		{
			

			/**
			 * loop thru and process the feeds
			 */

			$feeds = GFAPI::get_feeds( NULL, $entry[ 'form_id' ], $this->_slug );
			foreach( (array)$feeds AS $feed )
				self::process_feed_update( $feed, $entry, $form );
			
				
		} 



		/**
		 * process the feeds after the entry was changed from the backend
		 *
		 * @param $form array the current form
		 * @param $entry_id int the entry id
		 * @param $original_entry array the entry before the changes
		 */

		function spgfwpdb_gform_after_update_entry( $form, $entry_id, $original_entry )
		{
			

			$entry = GFAPI::get_entry( $entry_id );


			/**
			 * loop thru and process the feeds
			 */

			$feeds = GFAPI::get_feeds( NULL, $entry[ 'form_id' ], $this->_slug );
			foreach( (array)$feeds AS $feed )
				self::process_feed_update( $feed, $entry, $form );
			
				
		} 



		/**
		 * delete a record from WPDB after the entry was deleted at the backend or with he GFAPI
		 *
		 * @param $entry_id int the entry id
		 * @param $form array the current form
		 */

		function spgfwpdb_gform_delete_lead( $entry_id, $form = '' )
		{

			
			$entry = GFAPI::get_entry( $entry_id );


			/**
			 * loop thru and process the feeds
			 */

			$feeds = GFAPI::get_feeds( NULL, $entry[ 'form_id' ], $this->_slug );
			foreach( (array)$feeds AS $feed )
				self::process_feed_delete( $feed, $entry, $form );
			
				
		}



		/**
		 * empty the trash and delete all trashed entries
		 *
		 * @param $form_id int the form id
		 * @param $status string the delete status
		 */

		function spgfwpdb_gform_delete_entries( $form_id, $status )
		{

			/**
			 * only if we empty the trash
			 */
			if( $status == 'trash' )
			{
						
						
				$feeds = GFAPI::get_feeds( NULL, $form_id, $this->_slug );
						
							
				/**
				 * retrieve all assigned entries from the database
				 */

				global $wpdb;
				$lead_table = RGFormsModel::get_lead_table_name();
				$entries = $wpdb->get_results( "SELECT * FROM {$lead_table} WHERE form_id={$form_id} AND status='{$status}';", ARRAY_A );
				foreach( $entries AS $entry ) 
				{

					foreach( (array)$feeds AS $feed )
						self::process_feed_delete( $feed, $entry, $form );
								
					
				}
						
			}
					
					
		}
				
				
				

		/**
		 * add choices from a MySQL-query
		 *
		 * @param $form array the current form
		 * @param $ajax bool if ajax is enabled or not
		 * @param $field_values array the current valaues for thsi field
		 *
		 * @return array
		 */

		function spgfwpdb_gform_pre_render( $form, $ajax, $field_values )
		{

		
			/**
			 * loop thru the fields to get the fields
			 * with a choices statement
			 */

			foreach( $form[ 'fields' ] as $key => $field )
			{


				if( !empty( $field[ 'spgfwpdb_choices' ] ) )
				{

					
					/**
					 * we have a MySQL statement to build choices
					 */

					global $wpdb;
					unset( $choices );
							
							
					/**
					 * check with type of field we have
					 */

					switch( $field[ 'type' ] )
					{
								

						/**
						 * for pricing fields we need two or three values
						 */

						case 'option':
						case 'product':
						case 'shipping':

							$choices[] = array( 'text' => '', 'value' => '', 'price' => 0 );	
							$query = $field[ 'spgfwpdb_choices' ];
							$results = $wpdb->get_results( $query, ARRAY_N );
							if( $results )
							{

								foreach( (array)$results as $value )
								{
		
									if( count( $value ) > 2 )
										$choices[] = array( 'value' => $value[ 0 ], 'text' => $value[ 0 ] . ' | ' . $value[ 1 ], 'price' => floatval( $value[ 2 ] ) );	
									else
										$choices[] = array( 'value' => $value[ 0 ], 'text' => $value[ 0 ], 'price' => $value[ 1 ] );	

								}
										
							}
							break;

							
						/**
						 * by default we only deliver one or two values
						 */

						default:

							$choices[] = array( 'value' => '', 'text' => '' );	
							$query = $field[ 'spgfwpdb_choices' ];
							$results = $wpdb->get_results( $query, ARRAY_N );
							if( $results )
							{

								foreach( (array)$results as $value )
								{
		
									if( count( $value ) > 1 )
										$choices[] = array( 'value' => $value[ 0 ], 'text' => $value[ 0 ] . ' | ' . $value[ 1 ] );	
									else
										$choices[] = array( 'value' => $value[ 0 ], 'text' => $value[ 0 ] );	

								}
										
							}
							break;
									
					}

					$form[ 'fields' ][ $key ][ 'choices' ] = $choices;

				}
				
			}
			
			return( $form );
			
			
		}


				
		/**
		 * lookup the field value against a WPDB database table
		 *
		 * @param $result array the result array
		 * @param $value string the value of the field
		 * @param $form object the form object
		 * @param $field object the field object
		 *
		 * @return array
		 */

		function spgfwpdb_gform_field_validation( $result, $value, $form, $field )
		{

					
			/**
			 * if there isn't a look-up query, return with the given result
			 */

			if( $field[ 'spgfwpdb_lookup' ] )
			{
					
				/**
				 * if the field isn't valid, we doesn't need to perform any additional checks
				 */

				if( $result[ 'is_valid' ] )
				{
			
					/**
					 * if the field is empty, we doesn't need to perform a database look-up
					 */

					if( $value )
					{
					
						/** 
						 * build the query and lookup the database
						 */

						global $wpdb;
						$db_query = str_replace( '{field}', '%s', $field[ 'spgfwpdb_lookup' ] );
						
						if( $field[ 'type' ] == 'textarea' )
						{
									
							/**
							 * do a look-up for every line of the textarea
							 */

							$values = explode( '<br />', nl2br( $value ) );
							foreach( (array)$values AS $value )
							{

								$db_result = $wpdb->get_row( $wpdb->prepare( $db_query, array( trim( $value ) ) ), ARRAY_A );
								if( !$db_result )
								{
						
									/**
									 * value not found at the database
									 * return an error
									 */

									$result[ 'message' ] .= $value . ' : ' . __( "Could not look-up this value at the database", 'spgfwpdb' ) . '<br />';
									$result[ 'is_valid' ] = false;
										 
								}
										
							}
									
						} else
						{
								
							/**
							 * all other fields only have single values
							 */

							$db_result = $wpdb->get_row( $wpdb->prepare( $db_query, array( trim( $value ) ) ), ARRAY_A );
							if( !$db_result )
							{
						
								/**
								 * value not found at the database
								 * return an error
								 */

								$result[ 'message' ] = $value . ' : ' . __( "Could not look-up this value at the database", 'spgfwpdb' ) . '<br />';
								$result[ 'is_valid' ] = false;
										 
							}
					
						}
								
					}
							
				}
						
			}

					
			return( $result );
					
					
		}


		/**
		 * add a selectbox with all fieldnames to the advanced settings
		 *
		 * @param $position int the position of the setting
		 * @param $form_id int the id of the form
		 */

		function spgfwpdb_gform_field_advanced_settings( $position, $form_id )
		{
    
    
			/**
			 * display the advanced-field-settings at the end
			 */

			if( $position == -1 )
			{


				/**
				 * textarea to setup a MySQL Query to fill the choices
				 */

				?>
				<li class="spgfwpdb_choices_setting field_setting">
					<label for="spgfwpdb_choices">
						<?php _e( "MySQL-Query to fill the choices", 'spgfwpdb' ); ?>
					</label>
					<textarea id="spgfwpdb_choices_value" class="fieldwidth-3 fieldheight-2" onkeyup="SetFieldProperty('spgfwpdb_choices', jQuery(this).val() );"></textarea>
				</li>
				<?php
					

				/**
				 * textarea to setup a MySQL Query to look-up the field against a WPDB-table
				 */

				?>
				<li class="spgfwpdb_lookup_setting field_setting">
					<label for="spgfwpdb_lookup">
						<?php _e( "MySQL-Query to look-up your field", 'spgfwpdb' ); ?>
					</label>
					<textarea id="spgfwpdb_lookup_value" class="fieldwidth-3 fieldheight-2" onkeyup="SetFieldProperty('spgfwpdb_lookup', jQuery(this).val() );"></textarea>
				</li>
				<?php

						
			}


		}

			
			
		/**
		 * support the new advanced setting at the JS
		 */

		function spgfwpdb_gform_editor_js()
		{
    
    
			?>
			<script type='text/javascript'>
					
				fieldSettings["select"] += ", .spgfwpdb_choices_setting";
				fieldSettings["multiselect"] += ", .spgfwpdb_choices_setting";
				fieldSettings["checkbox"] += ", .spgfwpdb_choices_setting";
				fieldSettings["radio"] += ", .spgfwpdb_choices_setting";
				fieldSettings["list"] += ", .spgfwpdb_choices_setting";
				fieldSettings["product"] += ", .spgfwpdb_choices_setting";
				fieldSettings["option"] += ", .spgfwpdb_choices_setting";
				fieldSettings["shipping"] += ", .spgfwpdb_choices_setting";
				jQuery(document).bind("gform_load_field_settings", function(event, field, form) {
					jQuery("#spgfwpdb_choices_value").val(field.spgfwpdb_choices);
				});
						
				fieldSettings["text"] += ", .spgfwpdb_lookup_setting";
				fieldSettings["textarea"] += ", .spgfwpdb_lookup_setting";
				jQuery(document).bind("gform_load_field_settings", function(event, field, form) {
					jQuery("#spgfwpdb_lookup_value").val(field.spgfwpdb_lookup);
				});

			</script>
			<?php
				
				
		}
			
			


		/**
		 * --------------------------------------------------------------------------------
		 * functions to retrieve information from the database
		 * --------------------------------------------------------------------------------
		 */



		/**
		 * get an array of valid MYSQL table names fom the current WPDB database
		 *
		 * @return array
		 */

		private function spgfwpdb_get_table_names()
		{


			global $wpdb;
				
				
			/**
			 * build a query to retrieve all table-names of the current database
			 */

			$query = "SHOW TABLES FROM `" . DB_NAME . "`"; 
			$tables = $wpdb->get_results( $query, ARRAY_N );
				
			
			/**
			 * define an array with unneeded Tables (all WP and GF tables)
			 * comment the next lines if you need to include this tables
			 */

			$noTables = array(
				$wpdb->prefix . 'blogs',
				$wpdb->prefix . 'commentmeta',
				$wpdb->prefix . 'comments',
				$wpdb->prefix . 'gf_addon_feed',
				$wpdb->prefix . 'links',
				$wpdb->prefix . 'options',
				$wpdb->prefix . 'postmeta',
				$wpdb->prefix . 'posts',
				$wpdb->prefix . 'rg_form',
				$wpdb->prefix . 'rg_form_meta',
				$wpdb->prefix . 'rg_form_view',
				$wpdb->prefix . 'rg_incomplete_submissions',
				$wpdb->prefix . 'rg_lead',
				$wpdb->prefix . 'rg_lead_detail',
				$wpdb->prefix . 'rg_lead_detail_long',
				$wpdb->prefix . 'rg_lead_meta',
				$wpdb->prefix . 'rg_lead_notes',
				$wpdb->prefix . 'site',
				$wpdb->prefix . 'sitemeta',
				$wpdb->prefix . 'terms',
				$wpdb->prefix . 'term_relationships',
				$wpdb->prefix . 'term_taxonomy',
				$wpdb->prefix . 'usermeta',
				$wpdb->prefix . 'users'					
				);				
				
				
			/**
			 * build the return array
			 */

			foreach( $tables as $table )
			{
				
				if( !in_array( $table[0], $noTables ) )
					$choices[] = array( 'label' => $table[0], 'value' => $table[0] );
						
			}


			return( $choices );


		}



		/**
		 * get an array of valid MYSQL fields from the selected table
		 *
		 * @param $tableName string name of the selected table
		 *
		 * @return array
		 */

		private function spgfwpdb_get_field_names( $tableName )
		{


			global $wpdb;


			/**
			 * retrieve the field-names and build the options
			 */

			$results = $wpdb->get_results( "SHOW COLUMNS FROM {$tableName};", ARRAY_N );

			$fieldNames[] = array(
				'value'         => '',
				'label'         => '',
			);

			foreach( $results as $result )
				$fieldNames[] = array(
					'value'         => $result[0],
					'label'         => esc_html__( $result[0], 'sometextdomain' ),
				);


			$fieldNames = array(
				'label'   => esc_html__( 'Table field names', 'sometextdomain' ),
				'choices' => $fieldNames
			);


			$choices = array();
			$choices[] = $fieldNames;

			return( $choices );


		}
	
		
	
		/**
		 * get an array of valid MYSQL primary keys of the selected table
		 *
		 * @param $tableName string name of the selected table
		 *
		 * @return array
		 */

		private function spgfwpdb_get_primary_keys( $tableName )
		{


			global $wpdb;


			/**
			 * retrieve the field-names and build the options
			 */

			$results = $wpdb->get_results( "SHOW KEYS FROM {$tableName} WHERE Key_name = 'PRIMARY'", ARRAY_N );

			$fieldNames[] = array(
				'value'         => '',
				'label'         => '',
			);

			foreach( $results as $result )
				$fieldNames[] = array(
					'value'         => $result[4],
					'label'         => esc_html__( $result[4], 'sometextdomain' ),
				);


			$fieldNames = array(
				'label'   => esc_html__( 'Primary Key Name', 'sometextdomain' ),
				'choices' => $fieldNames
			);


			$choices = array();
			$choices[] = $fieldNames;

			return( $choices );


		}



		/**
		 * retrieve the MySQL column information about a field
		 *
		 * @param $table string name of the selected table
		 * @param $field string name of the selected field
		 *
		 * @return string
		 */

		function spgfwpdb_get_field_type( $table, $field )
		{


			global $wpdb;
			
			$results = $wpdb->get_results( "SHOW COLUMNS FROM `{$table}` LIKE '{$field}';", ARRAY_N );
			if( $results )
			{

				$pos = strpos( $results[ 0 ][ 1 ], '(' );
				if( $pos === false ) 
					$pos = strlen( $results[ 0 ][ 1 ] );
							
				$fieldType = substr( $results[ 0 ][ 1 ], 0, $pos );

				switch( $fieldType )
				{
						
					case 'float':
					case 'double':
					case 'decimal':
					case 'numeric':
						return( '%f' );
								
					case 'int':
					case 'bigint':
					case 'tinyint':
					case 'smallint':
					case 'mediumint':
					case 'integer':
						return( '%d' );
								
					default:
						return( '%s' );
								
				}
					
			}

			
		}
			
			

	}
