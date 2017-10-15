<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class GD_Dashboard_Pages {

    protected $main;

    protected $counts;

    protected $charts;

    public function __construct() {
        $this->main = new GD_Dashboard;
        $this->counts = new GD_Dashboard_Count;
        $this->charts = new GD_Dashboard_Chart;
    }

    public function geodir_dashboard_index_page() {
        if (isset($_GET['type'])) {
            $type = sanitize_text_field($_GET['type']);
        } else {
            $type = 'index';
        }
        ?>
        <div class="wrap">
            <?php
            $this->main->breadcrumb();
            if ($type == 'index') {
                echo $this->get_home_stats();
            }
            if ($type == 'listings') {
                echo $this->get_listings_stats();
            }
            if ($type == 'reviews') {
                echo $this->get_reviews_stats();
            }
            if ($type == 'cpt') {
                echo $this->get_listings_stats(false, true);
            }
            if ($type == 'locations') {
                echo $this->get_locations_stats();
            }
            if ($type == 'invoices') {
                echo $this->get_invoice_stats();
            }
            if ($type == 'prices') {
                echo $this->get_price_stats();
            }
            if ($type == 'users') {
                echo $this->get_user_stats();
            }
            ?>
        </div>

    <?php }

    public function get_home_stats() {
        ob_start();
        ?>
        <h2 class="gd-dashboard-title"><i class="fa fa-tachometer"></i> <?php echo "Geodirectory Dashboard"; ?></h2>
        <div class="container">
            <?php
            $args = array();

            $args[] = array(
                'link' => add_query_arg('type', 'listings', geodir_curPageURL()),
                'icon' => "fa-th-list",
                'title' => "Listings",
                'stats' => array(
                    'Listings' => $this->get_listings_stats(true)
                )
            );

            $args[] = array(
                'link' => add_query_arg('type', 'reviews', geodir_curPageURL()),
                'icon' => "fa-star",
                'title' => "Reviews",
                'stats' => array(
                    'Reviews' => $this->get_reviews_stats(true)
                )
            );

            if (defined('GEODIR_CP_VERSION')) {
                $args[] = array(
                    'link' => add_query_arg('type', 'cpt', geodir_curPageURL()),
                    'icon' => "fa-clone",
                    'title' => "Custom Post Types",
                    'stats' => array(
                        'Custom Post Types' => $this->get_listings_stats(true, true)
                    )
                );
            }

            if (defined('GEODIRPAYMENT_VERSION')) {
                $args[] = array(
                    'link' => add_query_arg('type', 'prices', geodir_curPageURL()),
                    'icon' => "fa-usd",
                    'title' => "Prices",
                    'stats' => array(
                        'Prices' => $this->counts->get_price_count()
                    )
                );

                $args[] = array(
                    'link' => add_query_arg('type', 'cpt', geodir_curPageURL()),
                    'icon' => "fa-credit-card",
                    'title' => "Payments",
                    'stats' => array(
                        'Payments' => $this->counts->get_payment_count()
                    )
                );

                $args[] = array(
                    'link' => add_query_arg('type', 'invoices', geodir_curPageURL()),
                    'icon' => "fa-file-text-o",
                    'title' => "Invoices",
                    'stats' => array(
                        'Invoices' => $this->counts->get_invoice_count()
                    )
                );

                $args[] = array(
                    'link' => add_query_arg('type', 'cpt', geodir_curPageURL()),
                    'icon' => "fa-tag",
                    'title' => "Coupons",
                    'stats' => array(
                        'Coupons' => $this->counts->get_coupon_count()
                    )
                );
            }

            if (defined('GEODIRCLAIM_VERSION')) {
                $args[] = array(
                    'link' => add_query_arg('type', 'claims', geodir_curPageURL()),
                    'icon' => "fa-question",
                    'title' => "Listing Claims",
                    'stats' => array(
                        'Listing Claims' => $this->counts->get_cliam_count()
                    )
                );
            }

            if (defined('GEODIRLOCATION_VERSION')) {
                $args[] = array(
                    'link' => add_query_arg('type', 'locations', geodir_curPageURL()),
                    'icon' => "fa-globe",
                    'title' => "Locations",
                    'stats' => array(
                        'Locations' => $this->counts->get_location_count()
                    )
                );
            }

            if (defined('BP_COMPLIMENTS_VER')) {
                $args[] = array(
                    'link' => '',
                    'icon' => "fa-smile-o",
                    'title' => "Compliments",
                    'stats' => array(
                        'Compliments' => $this->counts->get_compliments_count()
                    )
                );
            }

            $args[] = array(
                'link' => add_query_arg('type', 'users', geodir_curPageURL()),
                'icon' => "fa-user",
                'title' => "Users",
                'stats' => array(
                    'Users' => $this->counts->get_users_count()
                )
            );

            $labels = array();
            $data = array();
            foreach ($args as $arg) {
                foreach ($arg['stats'] as $key => $value) {
                    $labels[] = $key;
                    $data[] = $value;
                }
            }


            foreach ($args as $arg) {
                $this->main->generate_grid_html($arg);
            }

            $this->charts->generate_chart_js('bar', $labels, $data);
            ?>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function get_listings_stats($count_only = false, $cpt = false) {
        if (isset($_GET['subtype'])) {
            $subtype = sanitize_text_field($_GET['subtype']);
        } else {
            $subtype = 'index';
        }

        if ($subtype == 'index') {
            ob_start();
            if ($cpt) {
                $icon = 'fa fa-clone';
            } else {
                $icon = 'fa fa-th-list';
            }
            ?>
            <div class="container">
                <div class="row">
                    <?php
                    $all_postypes = geodir_get_posttypes('array');
                    $cpt_count = count($all_postypes);
                    $published = 0;
                    $draft = 0;
                    $trash = 0;
                    foreach ($all_postypes as $key => $posttype) {
                        $chart_labels[] = $posttype['labels']['name'];
                        $count_posts = wp_count_posts($key);
                        $published = $published + $count_posts->publish;
                        $draft = $draft + $count_posts->draft;
                        $trash = $trash + $count_posts->trash;
                        $total = $count_posts->publish + $count_posts->draft + $count_posts->trash;

                        //$link = admin_url( 'edit.php?post_type='.$key);

                        //if (!$cpt && $key == 'gd_event') {
                        $link = add_query_arg(array('type' =>'listings', 'subtype' => $key), geodir_curPageURL());
                        //}

                        $cat_count = wp_count_terms( $key.'category');
                        $tag_count = wp_count_terms( $key.'_tags');
                        $chart_data[] = $total;
                        $chart_cats[] = $cat_count;
                        $chart_tags[] = $tag_count;

                        $args = array(
                            'link' => $link,
                            'icon' => $icon,
                            'title' => $posttype['labels']['name'],
                            'stats' => array(
                                $posttype['labels']['name'] => $total,
                                $posttype['labels']['singular_name'].' '.'Categories' => $cat_count,
                                $posttype['labels']['singular_name'].' '.'Tags' => $tag_count,
                            )
                        );
                        $this->main->generate_grid_html($args);
                        ?>
                        <?php
                    }
                    $overall = $published + $draft + $trash;
                    $number_of_listings = $overall;
                    ?>
                </div>
            </div>
            <?php
            $output = ob_get_contents();
            ob_end_clean();
            if ($count_only) {
                if ($cpt) {
                    return $cpt_count;
                } else {
                    return $number_of_listings;
                }
            } else {
                if ($cpt) {
                    $return = '<h2 class="gd-dashboard-title"><i class="fa fa-th-list"></i> Custom Post Types ('.$cpt_count.')</h2>';
                } else {
                    $return = '<h2 class="gd-dashboard-title"><i class="fa fa-th-list"></i> Listings ('.$number_of_listings.')</h2>';
                }
                $return .= $output;
                return $return;
            }
        } elseif ($subtype == 'gd_event') {
            return $this->get_event_listings_stats($count_only);
        } else {
            return $this->get_listings_stats_chart($subtype);
        }
    }

    public function get_reviews_stats($count_only = false) {
        if (isset($_GET['subtype'])) {
            $subtype = sanitize_text_field($_GET['subtype']);
        } else {
            $subtype = 'index';
        }
        if ($subtype == 'index') {
            ob_start();
            ?>
            <div class="container">
                <div class="row">
                    <?php
                    $all_postypes = geodir_get_posttypes('array');
                    $total = 0;
                    foreach ($all_postypes as $key => $posttype) {
                        $count_reviews = $this->counts->count_reviews($key);
                        $total = $total + $count_reviews;
                        $link = add_query_arg(array('type' =>'reviews', 'subtype' => $key), geodir_curPageURL());
                        $args = array(
                            'link' => $link,
                            'icon' => 'fa-star',
                            'title' => $posttype['labels']['name'],
                            'stats' => array(
                                'Reviews' => $count_reviews,
                            )
                        );
                        $this->main->generate_grid_html($args);
                        ?>
                        <?php
                    }
                    $number_of_reviews = $total;
                    ?>
                </div>
            </div>
            <?php
            $output = ob_get_contents();
            ob_end_clean();
            if ($count_only) {
                return $number_of_reviews;
            } else {
                $return = '<h2 class="gd-dashboard-title"><i class="fa fa-star"></i> Reviews (' . $number_of_reviews . ')</h2>';
                $return .= $output;
                return $return;
            }
        } else {
            return $this->get_reviews_stats_chart($subtype);
        }
    }

    public function get_price_stats($count_only = false) {
        ob_start();
        ?>
        <div class="container">
            <div class="row">
                <?php
                $all_postypes = geodir_get_posttypes('array');
                $total = 0;
                foreach ($all_postypes as $key => $posttype) {
                    $count_packages = $this->counts->count_packages($key);
                    $total = $total + $count_packages;
                    $args = array(
                        'link' => admin_url( 'admin.php?page=geodirectory&tab=paymentmanager_fields&subtab=geodir_payment_manager'),
                        'icon' => 'fa-usd',
                        'title' => $posttype['labels']['name'],
                        'stats' => array(
                            'Packages' => $count_packages,
                        )
                    );
                    $this->main->generate_grid_html($args);
                    ?>
                    <?php
                }
                $number_of_packages = $total;
                ?>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        if ($count_only) {
            return $number_of_packages;
        } else {
            $return = '<h2 class="gd-dashboard-title"><i class="fa fa-usd"></i> Prices ('.$number_of_packages.')</h2>';
            $return .= $output;
            return $return;
        }
    }

    function get_user_stats() {
        return $this->get_users_stats_chart("users");
    }

    public function get_locations_stats() {
        ob_start();
        ?>
        <div class="container">
            <div class="row">
                <?php
                $args = array(
                    array(
                        'link' => '',
                        'icon' => "fa-globe",
                        'title' => "Countries",
                        'stats' => array(
                            'Countries' => $this->counts->get_location_count('country')
                        )
                    ),
                    array(
                        'link' => '',
                        'icon' => "fa-globe",
                        'title' => "Regions",
                        'stats' => array(
                            'Regions' => $this->counts->get_location_count('region')
                        )
                    ),
                    array(
                        'link' => '',
                        'icon' => "fa-globe",
                        'title' => "Cities",
                        'stats' => array(
                            'Cities' => $this->counts->get_location_count('city')
                        )
                    ),
                );

                $labels = array();
                $data = array();
                foreach ($args as $arg) {
                    foreach ($arg['stats'] as $key => $value) {
                        $labels[] = $key;
                        $data[] = $value;
                    }
                }

                foreach ($args as $arg) {
                    $this->main->generate_grid_html($arg);
                }

                $this->charts->generate_chart_js('bar', $labels, $data);
                ?>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function get_invoice_stats() {
        ob_start();
        ?>
        <div class="container">
            <div class="row">
                <?php
                $args = array(
                    array(
                        'link' => '',
                        'icon' => "fa-file-text-o",
                        'title' => "Confirmed",
                        'stats' => array(
                            'Confirmed' => $this->counts->get_invoice_count('confirmed')
                        )
                    ),
                    array(
                        'link' => '',
                        'icon' => "fa-file-text-o",
                        'title' => "Incomplete",
                        'stats' => array(
                            'Incomplete' => $this->counts->get_invoice_count('pending')
                        )
                    ),
                    array(
                        'link' => '',
                        'icon' => "fa-file-text-o",
                        'title' => "Cancelled",
                        'stats' => array(
                            'Cancelled' => $this->counts->get_invoice_count('cancelled')
                        )
                    ),
                    array(
                        'link' => '',
                        'icon' => "fa-file-text-o",
                        'title' => "Failed",
                        'stats' => array(
                            'Failed' => $this->counts->get_invoice_count('failed')
                        )
                    ),
                    array(
                        'link' => '',
                        'icon' => "fa-file-text-o",
                        'title' => "On Hold",
                        'stats' => array(
                            'On Hold' => $this->counts->get_invoice_count('onhold')
                        )
                    ),
                );

                $labels = array();
                $data = array();
                foreach ($args as $arg) {
                    foreach ($arg['stats'] as $key => $value) {
                        $labels[] = $key;
                        $data[] = $value;
                    }
                }

                foreach ($args as $arg) {
                    $this->main->generate_grid_html($arg);
                }

                $this->charts->generate_chart_js('bar', $labels, $data);
                ?>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function get_event_listings_stats($count_only = false) {
        ob_start();
        ?>
        <div class="container">
            <div class="row">
                <?php $this->charts->get_stats('gd_event', true); ?>
                <?php
                $args = array(
                    array(
                        'link' => '',
                        'icon' => "fa-calendar",
                        'title' => "Today",
                        'stats' => array(
                            'Today Events' => $this->counts->get_event_count('today')
                        )
                    ),
                    array(
                        'link' => '',
                        'icon' => "fa-calendar",
                        'title' => "Upcoming",
                        'stats' => array(
                            'Upcoming Events' => $this->counts->get_event_count('upcoming')
                        )
                    ),
                    array(
                        'link' => '',
                        'icon' => "fa-calendar",
                        'title' => "Past",
                        'stats' => array(
                            'Past Events' => $this->counts->get_event_count('past')
                        )
                    ),
                );

                $labels = array();
                $data = array();
                foreach ($args as $arg) {
                    foreach ($arg['stats'] as $key => $value) {
                        $labels[] = $key;
                        $data[] = $value;
                    }
                }

                foreach ($args as $arg) {
                    $this->main->generate_grid_html($arg);
                }

                $this->charts->generate_chart_js('bar', $labels, $data, 'gdDashEventListings');
                ?>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function get_listings_stats_chart($post_type = 'gd_place') {
        ob_start();
        ?>
        <div class="container">
            <div class="row">
                <?php $this->charts->get_stats($post_type, true); ?>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function get_reviews_stats_chart($post_type = 'gd_place') {
        ob_start();
        ?>
        <div class="container">
            <div class="row">
                <?php $this->charts->get_stats($post_type, true, true); ?>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function get_users_stats_chart($post_type = 'gd_place') {
        ob_start();
        ?>
        <div class="container">
            <div class="row">
                <?php $this->charts->get_stats($post_type, true, true); ?>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}