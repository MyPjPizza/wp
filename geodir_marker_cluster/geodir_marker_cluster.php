<?php
/**
 * This is the main plugin file, here we declare and call the important stuff
 *
 * @since 1.0.0
 * @package GeoDirectory_Marker_Cluster
 */

/*
Plugin Name: GeoDirectory Marker Cluster
Plugin URI: http://wpgeodirectory.com
Description: This plugin gives an advanced marker cluster system for Google Maps.
Version: 1.3.0
Author: GeoDirectory
Author URI: https://wpgeodirectory.com
Update URL: https://wpgeodirectory.com
Update ID: 65859
*/


/* Define Constants */
define("GDCLUSTER_VERSION", "1.3.0");
if (!defined('GEODIRMARKERCLUSTER_TEXTDOMAIN')) define('GEODIRMARKERCLUSTER_TEXTDOMAIN','geodir_markercluster');
define( 'GDCLUSTER_PLUGINDIR_PATH', WP_PLUGIN_DIR . "/" . plugin_basename( dirname(__FILE__) ) );
define( 'GDCLUSTER_PLUGINDIR_URL', plugins_url( '', __FILE__ ) );

global $plugin,$plugin_prefix,$geodir_addon_list;

//GEODIRECTORY UPDATE CHECKS
if (is_admin()) {
	if (!function_exists('ayecode_show_update_plugin_requirement')) {//only load the update file if needed
		require_once('gd_update.php'); // require update script
	}
}

///GEODIRECTORY CORE ALIVE CHECK START
if(is_admin()){
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(!is_plugin_active('geodirectory/geodirectory.php')){
return;
}}/// GEODIRECTORY CORE ALIVE CHECK END
$geodir_addon_list['geodir_marker_cluster'] = 'yes' ;

$plugin = plugin_basename( __FILE__ );
if(!isset($plugin_prefix))
	$plugin_prefix = $wpdb->prefix.'geodir_';


add_action('plugins_loaded','geodir_load_translation_markercluster');
function geodir_load_translation_markercluster()
{
    $locale = apply_filters('plugin_locale', get_locale(), 'geodir_markercluster');
    load_textdomain('geodir_markercluster', WP_LANG_DIR . '/' . 'geodir_markercluster' . '/' . 'geodir_markercluster' . '-' . $locale . '.mo');
    load_plugin_textdomain('geodir_markercluster', false, dirname(plugin_basename(__FILE__)) . '/geodir-markercluster-languages');

    include_once('language.php');
}

/**
 * Contains functions needed to server side cluster markers.
 *
 * @since 1.1.1
 */
include_once('geodir_serverside_cluster.php');



/**
 * Admin init + activation hooks
 **/
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) :
	register_activation_hook( __FILE__ , 'geodir_marker_cluster_activation' );
	register_deactivation_hook( __FILE__ , 'geodir_marker_cluster_deactivation' );
	add_filter('geodir_plugins_uninstall_settings', 'geodir_marker_cluster_uninstall_settings', 10, 1);
endif;


add_action('activated_plugin','geodir_marker_cluster_plugin_activated') ;
/**
 * Runs on plugin activation.
 *
 * Checks if GeoDirectory is insstalled and shows warning if not.
 *
 * @since 1.0.0
 * @param string $plugin The plugins base file name.
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_marker_cluster_plugin_activated($plugin)
{
	if (!get_option('geodir_installed')) 
	{
		$file = plugin_basename(__FILE__);
		if($file == $plugin) 
		{
			$all_active_plugins = get_option( 'active_plugins', array() );
			if(!empty($all_active_plugins) && is_array($all_active_plugins))
			{
				foreach($all_active_plugins as $key => $plugin)
				{
					if($plugin ==$file)
						unset($all_active_plugins[$key]) ;
				}
			}
			update_option('active_plugins',$all_active_plugins);
			
		}
		
		wp_die(__('<span style="color:#FF0000">There was an issue determining where GeoDirectory Plugin is installed and activated. Please install or activate GeoDirectory Plugin.</span>', 'geodir_markercluster'));
	}
	
}

/**
 * Runs on plugin activation.
 *
 * Installs the option to make the plugin redirect to the settings page on activation.
 *
 * @since 1.0.0
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_marker_cluster_activation() {
	if ( get_option( 'geodir_installed' ) ) {
		$options = geodir_map_marker_cluster( array() );
		$options = geodir_resave_settings( $options );
		geodir_update_options( $options, true );
		
		add_option( 'geodir_marker_cluster_activation_redirect_opt', 1 );
	}
}

add_action('admin_init', 'geodir_marker_cluster_activation_redirect');
/**
 * Checks if the plugin was just activated and if so redirects to the settings page.
 *
 * @since 1.0.0
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_marker_cluster_activation_redirect() {
	if (get_option('geodir_marker_cluster_activation_redirect_opt', false)) {
		delete_option('geodir_marker_cluster_activation_redirect_opt');
		wp_redirect(admin_url('admin.php?page=geodirectory&tab=design_settings&active_tab=geodir_marker_cluster_settings')); 
	}
}

/**
 * Runs on plugin deactivation.
 *
 * Blanks the plugin settings on deactivation.
 *
 * @since 1.0.0
 * @since 1.2.3 Moved options to delete under plugin uninstall hook.
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_marker_cluster_deactivation() {
}



/* Scripts loader */

add_action( 'wp_enqueue_scripts', 'gdcluster_templates_scripts',100);
if (!function_exists('gdcluster_templates_scripts')) {
    /**
     * Enqueues the plugins JS scripts.
     *
     * @since 1.0.0
     * @package GeoDirectory_Marker_Cluster
     */
    function gdcluster_templates_scripts() {
        $geodir_map_name = geodir_map_name();
        
        wp_enqueue_script( 'jquery' );

        if (in_array($geodir_map_name, array('auto', 'google'))) {
            if (!get_option('geodir_marker_cluster_type') || geodir_is_page('listing') || geodir_is_page('author') || geodir_is_page('search')
            || geodir_is_page('detail')) {
                wp_register_script('gdcluster-js', plugins_url( '', __FILE__ ) . '/js/marker_cluster.js', array('jquery'));
            } else {
                wp_register_script('gdcluster-js', plugins_url( '', __FILE__ ) . '/js/marker_cluster_ss.js', array('jquery'));
            }
            wp_enqueue_script( 'gdcluster-js' );

            wp_register_script( 'gdcluster-script', plugins_url( '', __FILE__ ).'/js/cluster_script.js',array('jquery','gdcluster-js'),'1',true );
            wp_enqueue_script('gdcluster-script');
        }

        if ($geodir_map_name == 'osm') {
            wp_register_style('gdcluster-leaflet-css', plugins_url( '', __FILE__ ) . '/js/leaflet/leaflet.markercluster.css', array(), GDCLUSTER_VERSION);
            wp_enqueue_style('gdcluster-leaflet-css');

            wp_register_script('gdcluster-leaflet-js', plugins_url( '', __FILE__ ) . '/js/leaflet/leaflet.markercluster.min.js', array('jquery', 'geodirectory-leaflet-script'), GDCLUSTER_VERSION);
            wp_enqueue_script('gdcluster-leaflet-js');
        }
    }
}

///add marker cluster option///
add_filter('geodir_design_settings' , 'geodir_map_marker_cluster', 2, 10 ) ;

/**
 * Adds the plugins settings to it's settings page.
 *
 * @since 1.0.0
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_map_marker_cluster($arr){

	$arr[] = array( 'name' => __( 'Marker  Cluster' , 'geodir_markercluster' ), 'type' => 'title', 'desc' => '', 'id' => 'geodir_marker_cluster_settings ' );
	
	

	$arr[] = array( 	'name' => __( 'Enable Marker Cluster',  'geodir_markercluster'),
				'type' => 'sectionstart',
				'desc' => '', 
				'id' => 'geodir_marker_cluster_settings' );
	
		$arr[] = array(  
				'name' => __( 'Show marker cluster on selected maps',  'geodir_markercluster'),
				'desc' 		=> '',
				'tip' 		=> '',
				'id' 		=> 'geodir_marker_cluster_on_maps',
				'css' 		=> 'min-width:300px;',
				'type' 		=> 'multiselect',
				'placeholder_text' => __( 'Select maps to cluster', 'geodir_markercluster' ),
				'class'		=> 'chosen_select',
				'options' => array_unique( geodir_map_marker_cluster_choose_maps())
			   );
		
	
	$arr[] = array( 'type' => 'sectionend', 'id' => 'geodir_marker_cluster_settings');
	
	
	$arr[] = array( 	'name' => __( 'Marker Cluster Settings',  'geodir_markercluster'),
				'type' => 'sectionstart',
				'desc' => '', 
				'id' => 'geodir_marker_cluster_settings_options' );
	
	$arr[] = array(  
			'name' => __( 'Cluster Type', 'geodir_markercluster' ),
			'desc' 		=> __( 'The type of clustering to use. Client side is better and faster for small directories, server side is better for large directories.', 'geodir_markercluster' ),
			'id' 		=> 'geodir_marker_cluster_type',
			'css' 		=> 'min-width:300px;',
			'std' 		=> '0',
			'type' 		=> 'select',
			'class'		=> 'chosen_select',
			'options' => array_unique( array( 
				'0' => __( 'Client side', 'geodir_markercluster' ),
				'1' => __( 'Server side', 'geodir_markercluster' ),
				))
		);

    $arr[] = array(
        'name' => __( 'Grid Size', 'geodir_markercluster' ),
        'desc' 		=> __( 'The grid size of a cluster in pixel. Each cluster will be a square. If you want the algorithm to run faster, you can set this value larger. The default value is 60', 'geodir_markercluster' ),
        'id' 		=> 'geodir_marker_cluster_size',
        'css' 		=> 'min-width:300px;',
        'std' 		=> '60',
        'type' 		=> 'select',
        'class'		=> 'chosen_select',
        'options' => array_unique( array(
            '60' => __( 'Default (60)', 'geodir_markercluster' ),
            '10' => __( '10', 'geodir_markercluster' ),
            '20' => __( '20', 'geodir_markercluster' ),
            '30' => __( '30', 'geodir_markercluster' ),
            '40' => __( '40', 'geodir_markercluster' ),
            '50' => __( '50', 'geodir_markercluster' ),
            '70' => __( '70', 'geodir_markercluster' ),
            '80' => __( '80', 'geodir_markercluster' ),
            '90' => __( '90', 'geodir_markercluster' ),
            '100' => __( '100', 'geodir_markercluster' ),
        ))
    );
	
	$arr[] = array(  
			'name' => __( 'Max Zoom', 'geodir_markercluster' ),
			'desc' 		=> __( 'The max zoom level monitored by a marker cluster. When maxZoom is reached or exceeded all markers will be shown without cluster.', 'geodir_markercluster' ),
			'id' 		=> 'geodir_marker_cluster_zoom',
			'css' 		=> 'min-width:300px;',
			'std' 		=> '15',
			'type' 		=> 'select',
			'class'		=> 'chosen_select',
			'options' => array_unique( array( 
				'15' => __( 'Default (15)', 'geodir_markercluster' ),
				'1' => __( '1', 'geodir_markercluster' ),
				'2' => __( '2', 'geodir_markercluster' ),
				'3' => __( '3', 'geodir_markercluster' ),
				'4' => __( '4', 'geodir_markercluster' ),
				'5' => __( '5', 'geodir_markercluster' ),
				'6' => __( '6', 'geodir_markercluster' ),
				'7' => __( '7', 'geodir_markercluster' ),
				'8' => __( '8', 'geodir_markercluster' ),
				'9' => __( '9', 'geodir_markercluster' ),
				'10' => __( '10', 'geodir_markercluster' ),
				'11' => __( '11', 'geodir_markercluster' ),
				'12' => __( '12', 'geodir_markercluster' ),
				'13' => __( '13', 'geodir_markercluster' ),
				'14' => __( '14', 'geodir_markercluster' ),
				'16' => __( '16', 'geodir_markercluster' ),
				'17' => __( '17', 'geodir_markercluster' ),
				'18' => __( '18', 'geodir_markercluster' ),
				'19' => __( '19', 'geodir_markercluster' ),

				))
		);
	$arr[] = array( 'type' => 'sectionend', 'id' => 'geodir_marker_cluster_settings_options');
	return $arr;
}

/**
 * Checks if the selected map has been selected to be clustered.
 *
 * @since 1.0.0
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_map_marker_cluster_choose_maps() {
	
	$home_map_widgets = get_option('widget_geodir_map_v3_home_map');
	
	$map_canvas_arr = array();
	
	if (!empty($home_map_widgets)) {
		foreach ($home_map_widgets as $key => $value) {
			if (is_numeric($key)) {
				$map_canvas_arr['geodir_map_v3_home_map_' . $key] = 'geodir_map_v3_home_map_' . $key;
			}
		}
	}
	
	return apply_filters('geodir_map_marker_cluster_choose_maps', $map_canvas_arr);
}


//now modify the widget, enable marker cluster options
// apply filters
$marker_cluster_maps = get_option('geodir_marker_cluster_on_maps') ;
if(!empty($marker_cluster_maps) && is_array($marker_cluster_maps))
{
	foreach($marker_cluster_maps as $map_canvas_name)
	{
	  	add_filter('geodir_map_options_' . $map_canvas_name , 'geodir_marker_cluster_update_map_options') ;
	}
}

/**
 * Add settings to the map options as needed for clustering.
 *
 * @since 1.0.0
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_marker_cluster_update_map_options($map_options) {
    $map_options['enable_marker_cluster'] = true;

    if (strpos($map_options['map_canvas_name'], 'home_map') !== false && get_option('geodir_marker_cluster_type')) {
        if ($map_options['autozoom']) {
            $map_options['enable_marker_cluster_no_reposition'] = false;
        } else {
            $map_options['enable_marker_cluster_no_reposition'] = true;
        }

        $map_options['enable_marker_cluster_server'] = true;
    } else {
        $map_options['enable_marker_cluster_server'] = false;
    }

    return $map_options ;
}

add_filter( 'geodir_all_js_msg', 'geodir_marker_cluster_add_settings_msg', 10, 1 );
/**
 * Add JS messages for the clustering script.
 *
 * @since 1.0.0
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_marker_cluster_add_settings_msg($msgs){
	global $wpdb;
	
	if($size = get_option('geodir_marker_cluster_size')){
		$msgs['geodir_marker_cluster_size'] = $size;
	}
	
	if($size = get_option('geodir_marker_cluster_zoom')){
		$msgs['geodir_marker_cluster_zoom'] = $size;
	}
    
    $imagePath = plugins_url( '', __FILE__ ) . '/images/m';
    
    /**
     * Filter the map marker cluster images path.
     *
     * @since 1.2.6
     * @param string $imagePath Marker cluster images path.
     */
    $msgs['imagePath'] = apply_filters('geodir_marker_cluster_image_path', $imagePath);
	return $msgs;
}

add_action('wp_head', 'geodir_marker_cluster_load_style', 11);
/**
 * Adds the marker cluster style for OpenStreetMap when Google JS Library not loaded.
 *
 * @since 1.2.6
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_marker_cluster_load_style() {
    if (in_array(geodir_map_name(), array('auto', 'google')) && wp_script_is( 'geodirectory-googlemap-script', 'done')) {
?>
<script type="text/javascript">
if (!(window.google && typeof google.maps !== 'undefined')) {
    document.write('<' + 'link id="gdcluster-leaflet-css" media="all" type="text/css" href="<?php echo plugins_url( '', __FILE__ );?>/js/leaflet/leaflet.markercluster.css?ver=<?php echo GDCLUSTER_VERSION;?>" rel="stylesheet"' + '>');
}
</script>
<?php
    }
}

add_action('wp_footer', 'geodir_marker_cluster_load_script', 11);
/**
 * Adds the marker cluster script for OpenStreetMap when Google JS Library not loaded.
 *
 * @since 1.2.6
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_marker_cluster_load_script() {
    if (in_array(geodir_map_name(), array('auto', 'google')) && wp_script_is( 'geodirectory-googlemap-script', 'done')) {
?>
<script type="text/javascript">
if (!(window.google && typeof google.maps !== 'undefined')) {
    document.write('<' + 'script id="gdcluster-leaflet-js" script src="<?php echo plugins_url( '', __FILE__ );?>/js/leaflet/leaflet.markercluster.min.js?ver=<?php echo GDCLUSTER_VERSION;?>"><' + '/script>');
}
</script>
<?php
    }
}

/**
 * Add the plugin to uninstall settings.
 *
 * @since 1.2.7
 *
 * @return array $settings the settings array.
 * @return array The modified settings.
 */
function geodir_marker_cluster_uninstall_settings($settings) {
    $settings[] = plugin_basename(dirname(__FILE__));
    
    return $settings;
}