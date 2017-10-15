<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class GD_Dashboard_Count {

    public function __construct() {

    }

    function get_price_count() {
        global $wpdb;
        $post_types = geodir_get_posttypes();
        $post_types_length = count($post_types);
        $format = array_fill(0, $post_types_length, '%s');
        $format = implode(',', $format);

        $count = $wpdb->get_var($wpdb->prepare("select count(*) from ".GEODIR_PRICE_TABLE." WHERE post_type IN ($format)", $post_types));
        return $count;
    }

    function get_coupon_count() {
        global $wpdb;
        $post_types = geodir_get_posttypes();
        $post_types_length = count($post_types);
        $format = array_fill(0, $post_types_length, '%s');
        $format = implode(',', $format);

        $count = $wpdb->get_var($wpdb->prepare("select count(*) from ".COUPON_TABLE." WHERE post_types IN ($format)", $post_types));
        return $count;
    }

    function get_payment_count() {
        global $wpdb;
        $count = $wpdb->get_var($wpdb->prepare("select count(*) from $wpdb->options where option_name like %s",array('payment_method_%')));
        return $count;
    }

    function get_cliam_count() {
        global $wpdb;
        $count = $wpdb->get_var("select count(*) from ".GEODIR_CLAIM_TABLE."");
        return $count;

    }

    function get_location_count($type = 'all') {
        $count = 0;
        global $wpdb;
        if ($type == 'all') {
            $location_items = geodir_manage_location_get_list();
            $count = count($location_items['items']);
        } elseif ($type == 'country') {
            $count = $wpdb->get_var("SELECT COUNT(DISTINCT country_slug) FROM ".POST_LOCATION_TABLE."");
        } elseif ($type == 'region') {
            $count = $wpdb->get_var("SELECT COUNT(DISTINCT region_slug) FROM ".POST_LOCATION_TABLE."");
        } elseif ($type == 'city') {
            $count = $wpdb->get_var("SELECT COUNT(DISTINCT city_slug) FROM ".POST_LOCATION_TABLE."");
        }
        return $count;

    }

    function get_compliments_count() {
        global $wpdb;
        $count = $wpdb->get_var("select count(*) from ".BP_COMPLIMENTS_TABLE."");
        return $count;
    }

    function get_users_count() {
        global $wpdb;
        $count = $wpdb->get_var("SELECT COUNT( ID ) FROM {$wpdb->users}");
        return $count;
    }

    function get_invoice_count($type = 'all') {

        global $wpdb;

        if ($type == 'all') {
            $count = $wpdb->get_var("select count(*) from ".INVOICE_TABLE."");
        } else {
            $count = $wpdb->get_var($wpdb->prepare("select count(*) from ".INVOICE_TABLE." WHERE status = %s", $type));
        }

        return $count;

    }

    function get_event_count($type = 'all') {
        $count = 0;
        $query_args = array(
            'post_type' => 'gd_event',
            'is_geodir_loop' => true,
        );

        if ($type == 'all') {
            $query_args['geodir_event_type'] = 'all';
            $count = geodir_event_get_widget_events( $query_args, true );
        }

        if ($type == 'today') {
            $query_args['geodir_event_type'] = 'feature';
            $count = geodir_event_get_widget_events( $query_args, true );
        }

        if ($type == 'upcoming') {
            $query_args['geodir_event_type'] = 'upcoming';
            $count = geodir_event_get_widget_events( $query_args, true );
        }

        if ($type == 'past') {
            $query_args['geodir_event_type'] = 'past';
            $count = geodir_event_get_widget_events( $query_args, true );
        }
        return $count;
    }

    public function count_reviews($post_type)
    {
        global $wpdb;

        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT( overall_rating ) FROM " . GEODIR_REVIEW_TABLE . " WHERE post_type = %s AND post_status = 1 AND status=1 AND overall_rating>0", $post_type));

        return $count;
    }


    public function count_packages($post_type)
    {
        global $wpdb;

        $count = $wpdb->get_var($wpdb->prepare("select count(*) from ".GEODIR_PRICE_TABLE." WHERE post_type = %s", $post_type));
        return $count;
    }

    public function count_by_week_new($post_type, $date, $is_review = false) {
        global $wpdb;
        if ($post_type == 'users') {
            $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT( ID ) FROM {$wpdb->users} WHERE user_registered = %s", $date));
        } else {
            if ($is_review) {
                $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT( overall_rating ) FROM " . GEODIR_REVIEW_TABLE . " WHERE post_type = %s AND post_status = 1 AND post_date = %s AND status=1 AND overall_rating>0", $post_type, $date));
            } else {
                $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT( ID ) FROM {$wpdb->posts} WHERE post_type = %s AND ( post_status = 'publish' OR post_status = 'draft' OR post_status = 'private' ) AND post_date = %s", $post_type, $date));
            }
        }
        return $count;
    }

    public function count_by_date_total($post_type, $date, $is_review = false) {
        global $wpdb;
        if ($post_type == 'users') {
            $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT( ID ) FROM {$wpdb->users} WHERE user_registered < %s", $date));
        } else {
            if ($is_review) {
                $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT( overall_rating ) FROM " . GEODIR_REVIEW_TABLE . " WHERE post_type = %s AND post_status = 1 AND post_date < %s AND status=1 AND overall_rating>0", $post_type, $date));
            } else {
                $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT( ID ) FROM {$wpdb->posts} WHERE post_type = %s AND ( post_status = 'publish' OR post_status = 'draft' OR post_status = 'private' ) AND post_date < %s", $post_type, $date));
            }
        }

        return $count;
    }

    public function count_by_range_new($post_type, $start_date, $end_date, $is_review = false) {
        global $wpdb;

        if ($post_type == 'users') {
            $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT( ID ) FROM {$wpdb->users} WHERE user_registered > %s AND user_registered < %s", $start_date, $end_date));
        } else {
            if ($is_review) {
                $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT( overall_rating ) FROM " . GEODIR_REVIEW_TABLE . " WHERE post_type = %s AND post_status = 1 AND post_date > %s AND post_date < %s AND status=1 AND overall_rating>0", $post_type, $start_date, $end_date));
            } else {
                $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT( ID ) FROM {$wpdb->posts} WHERE post_type = %s AND ( post_status = 'publish' OR post_status = 'draft' OR post_status = 'private' ) AND post_date > %s AND post_date < %s", $post_type, $start_date, $end_date));
            }
        }

        return $count;
    }
}