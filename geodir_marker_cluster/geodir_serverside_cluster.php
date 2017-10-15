<?php
/**
 * Script used to do server side clustering
 *
 * @package GeoDirectory_Marker_Cluster
 * @since 1.1.1
 */



if((isset($_REQUEST['lat_ne']) && $_REQUEST['lat_ne']) || (isset($_REQUEST['my_lat']) && $_REQUEST['my_lat'])) {
    add_filter('geodir_marker_search', 'geodir_cluster_marker_search', 10, 1);
    if(get_option('geodir_marker_cluster_type')) {
        remove_filter('geodir_marker_search', 'geodir_location_manager_location_me', 10, 1);
    }
}

/**
 * Filters the map query for server side clustering.
 *
 * Alters the query to limit the search area to the bounds of the map view.
 *
 * @since 1.1.1
 * @param string $search The where query string for marker search.
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_cluster_marker_search($search){
    if(!get_option('geodir_marker_cluster_type')){return $search;}

    if(isset($_REQUEST['my_lat']) && $_REQUEST['my_lat']) {
        $my_lat = filter_var($_REQUEST['my_lat'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $my_lon = filter_var($_REQUEST['my_lon'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        
        global $gd_session;
        if (is_numeric($gd_session->get('near_me_range'))) {
            $distance_in_miles = $gd_session->get('near_me_range');
        } else if (get_option('geodir_near_me_dist') != '') {
            $distance_in_miles = get_option('geodir_near_me_dist');
        } else {
            $distance_in_miles = 50;
        }

        $data = geodir_mc_bounding_box($my_lat, $my_lon, $distance_in_miles);

        $lat_sw = filter_var($data[0], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $lat_ne = filter_var($data[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $lon_sw = filter_var($data[2], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $lon_ne = filter_var($data[3], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }else {

        $lat_sw = filter_var($_REQUEST['lat_sw'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $lat_ne = filter_var($_REQUEST['lat_ne'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $lon_sw = filter_var($_REQUEST['lon_sw'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $lon_ne = filter_var($_REQUEST['lon_ne'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }


    $lon_not = '';
    //if the corners span more than half the world

    if($lon_ne>0 && $lon_sw>0 && $lon_ne<$lon_sw){$lon_not = 'not'; }
    elseif($lon_ne<0 && $lon_sw<0 && $lon_ne<$lon_sw){$lon_not = 'not';}
    elseif($lon_ne<0 && $lon_sw>0 && ($lon_ne+360-$lon_sw)>180){$lon_not = 'not';}
    elseif($lon_ne<0 && $lon_sw>0 && abs($lon_ne)+abs($lon_sw)>180){$lon_not = 'not';}
    //elseif($lon_ne>0 && $lon_sw<0 && ($lon_sw+360-$lon_ne)<180){$lon_not = 'not';}
//print_r($_REQUEST);
    if($lon_ne==180 && $lon_sw==-180){return $search;}

    $search .= " AND pd.post_latitude between least($lat_sw,$lat_ne) and greatest($lat_sw,$lat_ne)  AND pd.post_longitude $lon_not between least($lon_sw,$lon_ne) and greatest($lon_sw,$lon_ne)";

    return $search;
}

if(isset($_REQUEST['zl']) && $_REQUEST['zl']) {
    add_filter('geodir_before_marker_post_process', 'geodir_cluster_markers_process', 10, 1);
}

/**
 * Filters the map marker array and return them as a cluster array.
 *
 * @since 1.1.1
 * @param array $markers The array of markers found.
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_cluster_markers_process($markers) {
	global $gd_session;

    if (!is_array($markers) || !get_option('geodir_marker_cluster_type')) {
		return $markers;
	}
    $time = microtime(true);

    $distance = get_option('geodir_marker_cluster_size');
    $zoom = (isset($_REQUEST['zl']) && $_REQUEST['zl']) ? esc_attr($_REQUEST['zl']): 1;
    $max_zoom = get_option('geodir_marker_cluster_zoom');

    if (isset($_REQUEST['zl']) && isset($_REQUEST['gd_map_h']) && isset($_REQUEST['gd_map_w'])) {
        $bounds_markers = geodir_get_cluster_bounds($markers);
        
        if (!empty($bounds_markers)) {
            $mapDim = array(
                'h' => filter_var($_REQUEST['gd_map_h'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'w' => filter_var($_REQUEST['gd_map_w'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)
            );
            $zoom =  geodir_getBoundsZoomLevel($bounds_markers, $mapDim);
        }
    }

    // if max zoom for custer is reached then bail
    if ($zoom >= $max_zoom) {
		return $markers;
	}

    $clustered = array();
    /* Loop until all markers have been compared. */
    $distance = (10000000 >> $zoom) / 100000;
    while (count($markers)) {
        $marker  = array_pop($markers);
        $cluster = array();
        $max_lat = '';
        $max_lon = '';
        $min_lat = '';
        $min_lon = '';

        /* Compare against all markers which are left. */
        foreach ($markers as $key => $target) {
            $pixels = abs($marker->post_latitude - $target->post_latitude) + abs($marker->post_longitude - $target->post_longitude);

            if(!$max_lat){$max_lat = $marker->post_latitude;}elseif($max_lat<$marker->post_latitude){$max_lat = $marker->post_latitude;}
            if(!$min_lat){$min_lat = $marker->post_latitude;}elseif($min_lat>$marker->post_latitude){$min_lat = $marker->post_latitude;}
            if(!$max_lon){$max_lon = $marker->post_longitude;}elseif($max_lon>$marker->post_longitude){$max_lon = $marker->post_longitude;}
            if(!$min_lon){$min_lon = $marker->post_longitude;}elseif($min_lon<$marker->post_longitude){$min_lon = $marker->post_longitude;}

            /* If two markers are closer than given distance remove */
            /* target marker from array and add it to cluster.      */
            if ($distance > $pixels) {
                unset($markers[$key]);

                $cluster[] = $target;
            }
        }

        /* If a marker has been added to cluster, add also the one  */
        /* we were comparing to and remove the original from array. */
        if (count($cluster) > 0) {
            $cluster[] = $marker;

            $c_count = count($cluster);

            $max_lat = '';
            $max_lon = '';
            $min_lat = '';
            $min_lon = '';

            $num_coords = count($cluster);

            $X = 0.0;
            $Y = 0.0;
            $Z = 0.0;

            foreach ($cluster as $coord)
            {
                $lat = $coord->post_latitude * pi() / 180;
                $lon = $coord->post_longitude * pi() / 180;

                $a = cos($lat) * cos($lon);
                $b = cos($lat) * sin($lon);
                $c = sin($lat);

                $X += $a;
                $Y += $b;
                $Z += $c;

                if(!$max_lat){$max_lat = $coord->post_latitude;}elseif($max_lat<$coord->post_latitude){$max_lat = $coord->post_latitude;}
                if(!$min_lat){$min_lat = $coord->post_latitude;}elseif($min_lat>$coord->post_latitude){$min_lat = $coord->post_latitude;}
                if(!$max_lon){$max_lon = $coord->post_longitude;}elseif($max_lon>$coord->post_longitude){$max_lon = $coord->post_longitude;}
                if(!$min_lon){$min_lon = $coord->post_longitude;}elseif($min_lon<$coord->post_longitude){$min_lon = $coord->post_longitude;}
            }

            $X /= $num_coords;
            $Y /= $num_coords;
            $Z /= $num_coords;

            $lon = atan2($Y, $X);
            $hyp = sqrt($X * $X + $Y * $Y);
            $lat = atan2($Z, $hyp);

            $center = array($lat * 180 / pi(), $lon * 180 / pi());

            $clust = new stdClass();
            $clust->default_category = '';
            $clust->gd_placecategory = '';
            $clust->post_title = $c_count;
            $clust->post_id = $cluster[0]->post_id;
            $clust->post_latitude = $center[0];
            $clust->post_longitude = $center[1];
            $clust->marker_extra = ',"cs":"'.$c_count.'_'.$max_lat.'_'.$max_lon.'_'.$min_lat.'_'.$min_lon.'"';

            $clustered[] = $clust;
        } else {
            $clustered[] = $marker;
        }
    }
    
    $gd_session->set('testing', '');
    return $clustered;
}
function geodir_cluster_markers_process2($markers) {
    if (!is_array($markers) || !get_option('geodir_marker_cluster_type')) {
        return $markers;
    }
    
    $distance = get_option('geodir_marker_cluster_size');
    $zoom = (isset($_REQUEST['zl']) && $_REQUEST['zl']) ? esc_attr($_REQUEST['zl']): 1;
    $max_zoom = get_option('geodir_marker_cluster_zoom');

    if (isset($_REQUEST['zl']) && isset($_REQUEST['gd_map_h']) && isset($_REQUEST['gd_map_w'])) {
        $bounds_markers = geodir_get_cluster_bounds($markers);
        
        if (!empty($bounds_markers)) {
            $mapDim = array(
                'h'=>filter_var($_REQUEST['gd_map_h'], FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION),
                'w'=>filter_var($_REQUEST['gd_map_w'], FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION)
            );
            $zoom =  geodir_getBoundsZoomLevel($bounds_markers, $mapDim);
        }
    }

    // if max zoom for custer is reached then bail
    if ($zoom>=$max_zoom) {
        return $markers;
    }

    $clustered = array();
    /* Loop until all markers have been compared. */
    while (count($markers)) {
        $marker  = array_pop($markers);
        $cluster = array();

        /* Compare against all markers which are left. */
        foreach ($markers as $key => $target) {
            $pixels = geodir_pixelDistance($marker->post_latitude, $marker->post_longitude,
                $target->post_latitude, $target->post_longitude,
                $zoom);
            /* If two markers are closer than given distance remove */
            /* target marker from array and add it to cluster.      */
            if ($distance > $pixels) {
                unset($markers[$key]);
                $cluster[] = $target;
            }
        }

        /* If a marker has been added to cluster, add also the one  */
        /* we were comparing to and remove the original from array. */
        if (count($cluster) > 0) {
            $cluster[] = $marker;
            $clustered[] = $cluster;
        } else {
            $clustered[] = $marker;
        }
    }


    $final_cluster = array();
    foreach($clustered as $bucket){

        if(is_object($bucket)){

            $final_cluster[] = $bucket;
        }elseif(is_array($bucket)){

            $count = count($bucket);
            $center = geodir_GetCenterFromDegrees($bucket);
            $bounds = geodir_get_cluster_bounds($bucket);

            if (!empty($bounds)) {
                $clust = new stdClass();
                $clust->default_category = '166';
                $clust->gd_placecategory = '166';
                $clust->post_title = $count;
                $clust->post_id = $bucket[0]->post_id;
                $clust->post_latitude = $center[0];
                $clust->post_longitude = $center[1];
                $clust->marker_extra = ',"cs":"'.$count.'_'.$bounds[0].'_'.$bounds[1].'_'.$bounds[2].'_'.$bounds[3].'"';

                $final_cluster[]= $clust;
            }
        }
    }

    return $final_cluster;

}

// helper functions


/**
 * Find the X value of an X/Y axis point reference for a given longitude.
 *
 * @since 1.1.1
 * @param float $lon The longitude number to be processed.
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_lonToX($lon) {
    $offset = 268435456;
    $radius = 85445659.4471; /* $offset / pi() */
    return round($offset + $radius * $lon * pi() / 180);
}

/**
 * Find the Y value of an X/Y axis point reference for a given longitude.
 *
 * @since 1.1.1
 * @param float $lat The latitude number to be processed.
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_latToY($lat) {
    $offset = 268435456;
    $radius = 85445659.4471; /* $offset / pi() */
    return round($offset - $radius *
        log((1 + sin($lat * pi() / 180)) /
            (1 - sin($lat * pi() / 180))) / 2);
}

/**
 * Find the distance in pixels between two GPS points.
 *
 * @since 1.1.1
 * @param float $lat1 The latitude number for the first point.
 * @param float $lon1 The longitude number for the first point.
 * @param float $lat2 The latitude number for the second point.
 * @param float $lon2 The longitude number for the second point.
 * @param int $zoom The map zoom level 1-21.
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_pixelDistance($lat1, $lon1, $lat2, $lon2, $zoom) {
    $x1 = geodir_lonToX($lon1);
    $y1 = geodir_latToY($lat1);

    $x2 = geodir_lonToX($lon2);
    $y2 = geodir_latToY($lat2);

    return sqrt(pow(($x1-$x2),2) + pow(($y1-$y2),2)) >> (21 - $zoom);
}

function geodir_pixelDistance2($lat1, $lon1, $lat2, $lon2, $zoom) {
    $x1 = $lon1*10000000; //This is what I did to compensate for using lat/lon values instead of pixels.
    $y1 = $lat1*10000000;
    $x2 = $lon2*10000000;
    $y2 = $lat2*10000000;

    return ($x1-$x2) + ($y1-$y2) >> (21 - $zoom);
}


/**
 * Get a center latitude,longitude from an array of like geopoints
 *
 * @param array data 2 dimensional array of latitudes and longitudes
 * For Example:
 * $data = array
 * (
 *   0 = > array(45.849382, 76.322333),
 *   1 = > array(45.843543, 75.324143),
 *   2 = > array(45.765744, 76.543223),
 *   3 = > array(45.784234, 74.542335)
 * );
 * @since 1.1.1
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_GetCenterFromDegrees($data)
{
    if (!is_array($data)) return FALSE;

    $num_coords = count($data);

    $X = 0.0;
    $Y = 0.0;
    $Z = 0.0;

    foreach ($data as $coord)
    {
        $lat = $coord->post_latitude * pi() / 180;
        $lon = $coord->post_longitude * pi() / 180;

        $a = cos($lat) * cos($lon);
        $b = cos($lat) * sin($lon);
        $c = sin($lat);

        $X += $a;
        $Y += $b;
        $Z += $c;
    }

    $X /= $num_coords;
    $Y /= $num_coords;
    $Z /= $num_coords;

    $lon = atan2($Y, $X);
    $hyp = sqrt($X * $X + $Y * $Y);
    $lat = atan2($Z, $hyp);

    return array($lat * 180 / pi(), $lon * 180 / pi());
}

/**
 * Find the bounds of the given cluster data.
 *
 * @since 1.1.1
 * @param array $data The array of cluster data.
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_get_cluster_bounds($data) {
    if (!is_array($data)) return array();

    $max_lat = '';
    $max_lon = '';
    $min_lat = '';
    $min_lon = '';

    foreach ($data as $target) {
        if(!$max_lat){$max_lat = $target->post_latitude;}elseif($max_lat<$target->post_latitude){$max_lat = $target->post_latitude;}
        if(!$min_lat){$min_lat = $target->post_latitude;}elseif($min_lat>$target->post_latitude){$min_lat = $target->post_latitude;}
        if(!$max_lon){$max_lon = $target->post_longitude;}elseif($max_lon>$target->post_longitude){$max_lon = $target->post_longitude;}
        if(!$min_lon){$min_lon = $target->post_longitude;}elseif($min_lon<$target->post_longitude){$min_lon = $target->post_longitude;}
    }

    return array($max_lat,$max_lon,$min_lat,$min_lon);
}

/**
 * Convert latitude to radian value.
 *
 * @since 1.1.1
 * @param float $lat The latitude value to convert.
 * @return float The latitude value in radians.
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_latRad($lat) {
    $sin = sin($lat * pi() / 180);
    $radX2 = log((1 + $sin) / (1 - $sin)) / 2;
    return max(min($radX2, pi()), -pi()) / 2;
}

/**
 * Calculate the maximum zoom level for two given points on a map.
 *
 * @since 1.1.1
 * @param float $mapPx The px value of the given point to check.
 * @param float $worldPx The px value of the world in pixels.
 * @param float $fraction The fraction distance between the two points to check.
 * @return int The max zoom level needed to view the point on a map 1-21.
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_cluster_zoom($mapPx, $worldPx, $fraction) {
    if( $fraction=='0'){ $fraction=1;}
    return floor(log($mapPx / $worldPx / $fraction) / M_LN2);
}

/**
 * Calculate the maximum zoom level on a map given the bounds array and the map size in pixels.
 *
 * @since 1.1.1
 * @param array $bounds The array of 4 points, the lat/lon of the north east and the lat/long of the south west.
 * @param array $mapDim An array of the map height and width in px value.
 * @return int The max zoom level needed to view the points on a map 1-21.
 * @package GeoDirectory_Marker_Cluster
 */
function geodir_getBoundsZoomLevel($bounds, $mapDim) {
    $world_dim = array( 'height'=> 256, 'width'=> 256 );
    $zoom_max = 21;
    
    $ne = array();
    $sw = array();

    $ne['lat'] = max($bounds[0], $bounds[2]);
    $ne['lon'] = max($bounds[1], $bounds[3]);
    $sw['lat'] = min($bounds[0], $bounds[2]);
    $sw['lon'] = min($bounds[1], $bounds[3]);

    if ($ne['lat'] == $sw['lat'] && $ne['lon'] == $sw['lon']) {
        return 20;
    }

    $latFraction = (geodir_latRad($ne['lat']) - geodir_latRad($sw['lat'])) / pi();

    $lngDiff = $ne['lon'] - $sw['lon'];
    $lngFraction = (($lngDiff < 0) ? ($lngDiff + 360) : $lngDiff) / 360;

    $latZoom = geodir_cluster_zoom($mapDim['h'], $world_dim['height'], $latFraction);
    $lngZoom = geodir_cluster_zoom($mapDim['w'], $world_dim['width'], $lngFraction);

    return min($latZoom, $lngZoom, $zoom_max);
}

function geodir_mc_bounding_box($lat_degrees,$lon_degrees,$distance_in_miles) {
    $radius = 3963.1; // of earth in miles

    // bearings - FIX
    $due_north = deg2rad(0);
    $due_south = deg2rad(180);
    $due_east = deg2rad(90);
    $due_west = deg2rad(270);

    // convert latitude and longitude into radians
    $lat_r = deg2rad($lat_degrees);
    $lon_r = deg2rad($lon_degrees);

    // find the northmost, southmost, eastmost and westmost corners $distance_in_miles away
    // original formula from
    // http://www.movable-type.co.uk/scripts/latlong.html
    
    $northmost  = asin(sin($lat_r) * cos($distance_in_miles/$radius) + cos($lat_r) * sin ($distance_in_miles/$radius) * cos($due_north));
    $southmost  = asin(sin($lat_r) * cos($distance_in_miles/$radius) + cos($lat_r) * sin ($distance_in_miles/$radius) * cos($due_south));

    $eastmost = $lon_r + atan2(sin($due_east)*sin($distance_in_miles/$radius)*cos($lat_r),cos($distance_in_miles/$radius)-sin($lat_r)*sin($lat_r));
    $westmost = $lon_r + atan2(sin($due_west)*sin($distance_in_miles/$radius)*cos($lat_r),cos($distance_in_miles/$radius)-sin($lat_r)*sin($lat_r));

    $northmost = rad2deg($northmost);
    $southmost = rad2deg($southmost);
    $eastmost = rad2deg($eastmost);
    $westmost = rad2deg($westmost);

    // sort the lat and long so that we can use them for a between query
    if ($northmost > $southmost) {
        $lat1 = $southmost;
        $lat2 = $northmost;
    } else {
        $lat1 = $northmost;
        $lat2 = $southmost;
    }

    if ($eastmost > $westmost) {
        $lon1 = $westmost;
        $lon2 = $eastmost;
    } else {
        $lon1 = $eastmost;
        $lon2 = $westmost;
    }

    return array($lat1,$lat2,$lon1,$lon2);
}
