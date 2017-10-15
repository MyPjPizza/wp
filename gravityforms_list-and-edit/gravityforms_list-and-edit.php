<?php


	/**
 	 Plugin Name: SP Gravity Forms List & Edit
	 Plugin URI: http://specialpress.de/plugins/spgfle
	 Description: Edit or Delete your Gravity Forms Entries
	 Version: 2.3.0
	 Date: 2017/02/26
	 Author: Ralf Fuhrmann
	 Author URI: http://naranili.de
	 */


	 
	/**
	 * Changes
	 * -------
	 * updated to Wordpress 4.7.x
	 * updated to Gravityforms 2.0.x
	 * updated to jQuery DataTables 1.10.12
	 * added support for conditional logic button
	 * fixed shortcode parameter handling
	 *
	 */
	
	
	
	/**
	 * To Do
	 * -----
	 * support for credit-card field
	 * switch to use post data instead of GF data, so it's possible to change the post from the wp-backend
	 * support for actions at the shortcode
	 * support for filtering at the shortcode
	 * support for user specified entries at the shortcode
	 * support for the user registration addon
	 * only change an entry if there isn't paid
	 * add role system
	 *
	 */
	 
	 
	 
	if( !isset( $_SESSION ) )
		session_start();
	
    error_reporting( E_ERROR );
 
 
	
	/**
	 * check if GF is active and include common classes
	 */
	if ( class_exists( 'GFForms' ) )
	{


		GFForms::include_addon_framework();


		/**
		 * check and maybe load the plugin classes
		 */
		if( !class_exists( 'SpGfListEdit' ) ) 
			require_once( 'gravityforms_list-and-edit.class.php' );
		if( !class_exists( 'SpGfDataTables' ) ) 
			require_once( 'gravityforms_datatables.class.php' );

	
	}

	
	
	/**
	 * if we are lesser than PHP 5.5 we have to
	 * create a function array_column
	 */
	if( !function_exists( 'array_column' ) )
	{

		function array_column( $array, $column_name )
		{

			return array_map( function( $element ) use( $column_name ){return $element[ $column_name ];}, $array );

		}

	}	
	
	
	/**
	 * add a small compare function
	 */
	if( !function_exists( 'uasort_compare_fieldorder' ) )
	{
		
		function uasort_compare_fieldorder( $a, $b ) 
		{
		
			return( $a[ 'spgfdt_fieldorder' ] > $b[ 'spgfdt_fieldorder' ] );
			
		}

	}
 

 
?>