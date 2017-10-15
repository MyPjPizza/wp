<?php


	/*
	 * Helper functions for building a DataTables server-side processing GF API call
	 *
	 * The static functions in this class are just helper functions to help build
	 * the SQL used in the DataTables demo server-side processing scripts. These
	 * functions obviously do not represent all that can be done with server-side
	 * processing, they are intentionally simple to show how it works. More complex
	 * server-side processing operations will likely require a custom script.
	 *
	 * See http://datatables.net/usage/server-side for full details on the server-
	 * side processing requirements of DataTables.
	 *
	 * @license MIT - http://datatables.net/license_mit
	 *
	 * Adjusted to Gravity Forms by Ralf Fuhrmann
	 * Version : 1.6.0
	 *
	 */

	 
	class SSP_GFAPI
	{
	
	
		/**
		 * Create the data output array for the DataTables rows
		 *
		 *  @param  array $columns Column information array
		 *  @param  array $data    Data from the SQL get
		 *  @return array          Formatted data in a row based format
		 */
		static function data_output ( $columns, $data )
		{
		
			$out = array();

			foreach( $data AS $record )
			{
		
				$row = array();

				for( $j = 0, $jen = count( $columns ); $j < $jen; $j++ ) 
				{
				
					$column = $columns[ $j ];

					/* Is there a formatter */
					if( isset( $column[ 'formatter' ] ) )
						$row[ $column[ 'dt' ] ] = $column[ 'formatter' ]( $record[ $column[ 'db' ] ], $record );
					else
						$row[ $column[ 'dt' ] ] = $record[ $columns[ $j ][ 'db' ] ];

				}

				$out[] = $row;
		
			}

			return( $out );
	
		}

		

		/**
		 * Perform the GFAPI query needed for an server-side processing requested,
		 * The returned array is ready to be encoded as JSON in response to an 
		 * SSP request, or can be modified if needed before
		 * sending back to the client.
		 *
		 *  @param  array $request	Data sent to server by DataTables
		 *  @param  array $columns	Column information array
		 *  @param	array $params	Gravity-Forms information array
		 *  @return array 			Server-side processing response array
		 */
		static function simple ( $request, $columns, $params )
		{
		
		
			/**
			 * get the form data
			 */
			$form = GFAPI::get_form( $params[ 'form_id' ] );
			
			
			
			/**
			 * get the current user and if the
			 * current user is an admin
			 */
			$currentUserID = wp_get_current_user()->ID;
			$currentUserAdmin = GFCommon::current_user_can_any( 'edit_forms' );
			
			
			
			/** 
			 * loop through the fields and build the
			 * field array of fields wich should be displayed
			 */
			foreach( (array)$form[ 'fields' ] AS $field )
			{
		
				/** 
				 * only display fields that are checked at the field-settings
				 */
				if( $field[ 'spgfdt_fieldorder' ] ) 
					$fields[ $field[ 'id' ] ] = $field;
							
			}
			

			
			/**
			 * construct the LIMIT clause for server-side processing GFAPI call
			 */
			$paging = null;
			if( rgar( $form, 'spgfdt_paging' ) ) 
			{
				
				if( isset( $request[ 'start' ] ) && $request[ 'length' ] != -1 )
					$paging = array( 'offset' => intval( $request[ 'start' ] ), 'page_size' => intval( $request[ 'length' ] ) );
				
			}

			
			
			/**
			 * construct the WHERE clause for server-side processing GFAPI call
			 */
			$search_criteria = null;
			if( rgar( $form, 'spgfdt_searching' ) ) 
			{
				
				if( isset( $request[ 'search' ] ) && $request[ 'search' ][ 'value' ] != '' ) 
				{
				
					$search_criteria[ 'status' ] = 'active';
					$search_criteria[ 'field_filters' ][] = array( 'key' => '0', 'operator' => 'contains', 'value' => $request[ 'search' ][ 'value' ] );
					
				}
			
			}
			
			
			/**
			 * add the filter to display the records only to the 
			 * needed type of user
			 */
			if( $params[ 'displayto' ] ) 
			{

				if( intval( $params[ 'displayto' ] ) == 2 )
				{

					$search_criteria[ 'status' ] = 'active';
					$search_criteria[ 'field_filters' ][] = array( 'key' => 'created_by', 'operator' => 'is', 'value' => $currentUserID );
			
				}

			}
			 
			
			/**
			 * construct the ORDER clause for server-side processing GFAPI call
			 */
			$sorting = null;
			if( rgar( $form, 'spgfdt_ordering' ) ) 
			{
			
				if ( isset( $request[ 'order' ] ) && count( $request[ 'order' ] ) ) 
				{
			
					$fieldNumber = array_search( $request[ 'order' ][ 0 ][ 'column' ], array_column( $columns, 'dt' ) );
					$dir = $request[ 'order' ][ 0 ][ 'dir' ] === 'asc' ? 'ASC' : 'DESC';				
					$sorting = array( 'key' => $columns[ $fieldNumber ][ 'db' ], 'direction' => $dir );		
				
				}
				
			}
			
			
			/**
			 * call the GFAPI to get the entries
			 */
			$total_count = 0;
			$entries = GFAPI::get_entries( intval( $params[ 'form_id' ] ), $search_criteria, $sorting, $paging, $total_count );		
			$filtered_count = count( $entries );

			foreach( (array)$entries AS $entry )
			{

				foreach( $columns AS $column )
				{
				
					if( $column[ 'db' ] != 'action' )
					{
					
						/**
						 * use the GF functions to display the data
						 * in the needed way
						 */
						$field = $fields[ $column[ 'db' ] ];
						$value = RGFormsModel::get_lead_field_value( $entry, $field );
						$display_value = GFCommon::get_lead_field_display( $field, $value, $entry[ 'currency' ], true );
						
						/**
						 * update data array
						 */
						$data[ (int)$entry[ 'id' ] ][ $column[ 'db' ] ] = $display_value;
						
					} else
					{
						
						
						/**
						 * if we have an action column for the Gravity Forms List & Edit plugin
						 * we add the action links, if it's allowed for the current user
						 */
						$data[ (int)$entry[ 'id' ] ][ 'action' ] =	'';

						 
						/**
						 * if the user must be logged in to work at an entry
						 * continue of the user isn't logged in
						 */
						if( $params[ 'workableby' ] > 0 && !$currentUserID )
							continue;						 						


						/**
						 * if the user must be an admin to work at an entry
						 * continue of the user isn't an admin
						 */
						if( $params[ 'workableby' ] > 2 && intval( $currentUserAdmin ) < 1 )
							continue;


						/**
						 * if it's only possible to edit the entry from the entry creator
						 * continue of the user isn't the entry creator
						 */
						if( $params[ 'workableby' ] == 2 && $entry[ 'created_by' ] != $currentUserID && !$currentUserAdmin )
							continue;
						
						
						 

						/**
						 * create the links to edit or delete an entry
						 */
						if( !empty( $form[ 'spgfle_change' ] ) )
						{
						
							if( $form[ 'spgfle_change' ] == 'icon' )
								$data[ (int)$entry[ 'id' ] ][ 'action' ] .= "&nbsp;<img src=\"" . plugins_url( 'icons/change.png', __FILE__ ) . "\" alt=\"" . __( "Change", 'spgfle' ) . "\" onClick=\"SetHiddenFormSettings({$entry[ 'id' ]}, 'change', 'GFAPI')\" />";
							else
								$data[ (int)$entry[ 'id' ] ][ 'action' ] .= "&nbsp;<button class=\"button button_addnew\" onClick=\"SetHiddenFormSettings({$entry[ 'id' ]}, 'change', 'GFAPI')\">" . __( "Change", 'spgfle' ) . "</button>";
						
						}
						
						if( !empty( $form[ 'spgfle_delete' ] ) )
						{
							
							if( $form[ 'spgfle_delete' ] == 'icon' )
								$data[ (int)$entry[ 'id' ] ][ 'action' ] .= "&nbsp;<img src=\"" . plugins_url( 'icons/delete.png', __FILE__ ) . "\" alt=\"" . __( "Delete", 'spgfle' ) . "\" onClick=\"SetHiddenFormSettings({$entry[ 'id' ]}, 'delete', 'GFAPI')\" />";
							else
								$data[ (int)$entry[ 'id' ] ][ 'action' ] .= "&nbsp;<button class=\"button button_addnew\" onClick=\"SetHiddenFormSettings({$entry[ 'id' ]}, 'delete', 'GFAPI')\">" . __( "Delete", 'spgfle' ) . "</button>";
						
						}
					
					}
			
				}
				
			}
			
			
			/*
			 * build the output array
			 */
			return( array(
				"draw"            => intval( $request[ 'draw' ] ),
				"recordsTotal"    => intval( $total_count ),
				"recordsFiltered" => intval( $total_count ),
				"data"            => self::data_output( $columns, $data )
			) );

		}
		
	}
	
	
?>