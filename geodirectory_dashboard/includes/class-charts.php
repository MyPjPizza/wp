<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class GD_Dashboard_Chart {

    public function __construct() {
        $this->counts = new GD_Dashboard_Count;
    }

    public function get_stats($post_type = 'gd_place', $echo = true, $is_review = false) {
        if (isset($_GET['duration'])) {
            $duration = sanitize_text_field($_GET['duration']);
        } else {
            $duration = 'this_year';
        }
        ob_start();
        ?>
        <div class="gd-chart-wrap">
            <div class="gd-dash-btn-group" data-toggle="buttons">
                <label class="gd-dash-btn gd-dash-btn-sm gd-dash-btn-white <?php if ($duration == 'this_week') { echo "active"; } ?>">
                    <a href="<?php echo add_query_arg('duration', 'this_week', geodir_curPageURL()); ?>">This Week</a>
                </label>
                <label class="gd-dash-btn gd-dash-btn-sm gd-dash-btn-white <?php if ($duration == 'last_week') { echo "active"; } ?>">
                    <a href="<?php echo add_query_arg('duration', 'last_week', geodir_curPageURL()); ?>">Last Week</a>
                </label>
                <label class="gd-dash-btn gd-dash-btn-sm gd-dash-btn-white <?php if ($duration == 'this_month') { echo "active"; } ?>">
                    <a href="<?php echo add_query_arg('duration', 'this_month', geodir_curPageURL()); ?>">This Month</a>
                </label>
                <label class="gd-dash-btn gd-dash-btn-sm gd-dash-btn-white <?php if ($duration == 'last_month') { echo "active"; } ?>">
                    <a href="<?php echo add_query_arg('duration', 'last_month', geodir_curPageURL()); ?>">Last Month</a>
                </label>
                <label class="gd-dash-btn gd-dash-btn-sm gd-dash-btn-white <?php if ($duration == 'this_year') { echo "active"; } ?>">
                    <a href="<?php echo add_query_arg('duration', 'this_year', geodir_curPageURL()); ?>">This Year</a>
                </label>
                <label class="gd-dash-btn gd-dash-btn-sm gd-dash-btn-white <?php if ($duration == 'last_year') { echo "active"; } ?>">
                    <a href="<?php echo add_query_arg('duration', 'last_year', geodir_curPageURL()); ?>">Last Year</a>
                </label>
            </div>
            <div class="gd-dash-box-sep"></div>
            <?php
            $this->get_listings_stats($post_type, $duration, $is_review);
            ?>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();

        if ($echo) {
            echo $output;
        } else {
            return $output;
        }
        return false;
    }

    public function get_listings_stats($post_type, $duration = 'this_year', $is_review = false) {

        $total = array();
        $new = array();
        if ($duration == 'this_year') {
            $total = $this->get_stats_by_year($post_type, 'this_year', 'total', $is_review);
            $new = $this->get_stats_by_year($post_type, 'this_year', 'new', $is_review);
        } elseif ($duration == 'last_year') {
            $total = $this->get_stats_by_year($post_type, 'last_year', 'total', $is_review);
            $new = $this->get_stats_by_year($post_type, 'last_year', 'new', $is_review);
        } elseif ($duration == 'this_week') {
            $total = $this->get_stats_by_week($post_type, 'this_week', 'total', $is_review);
            $new = $this->get_stats_by_week($post_type, 'this_week', 'new', $is_review);
        } elseif ($duration == 'last_week') {
            $total = $this->get_stats_by_week($post_type, 'last_week', 'total', $is_review);
            $new = $this->get_stats_by_week($post_type, 'last_week', 'new', $is_review);
        } elseif ($duration == 'this_month') {
            $total = $this->get_stats_by_month($post_type, 'this_month', 'total', $is_review);
            $new = $this->get_stats_by_month($post_type, 'this_month', 'new', $is_review);
        } elseif ($duration == 'last_month') {
            $total = $this->get_stats_by_month($post_type, 'last_month', 'total', $is_review);
            $new = $this->get_stats_by_month($post_type, 'last_month', 'new', $is_review);
        }


        $labels = array_keys($total);

        $data_total = array_values($total);
        $data_new = array_values($new);

        ?>
        <canvas id="gdDashListings"></canvas>
        <script type="text/javascript">
            var ctx = document.getElementById('gdDashListings').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [<?php echo '"'.implode('","', $labels).'"'; ?>],
                    datasets: [{
                        label: 'Total',
                        data: [<?php echo '"'.implode('","', $data_total).'"'; ?>],
                        fillColor : "rgba(220,220,220,0.5)",
                        strokeColor : "rgba(220,220,220,1)",
                        pointColor : "rgba(220,220,220,1)",
                        pointStrokeColor : "#fff",
                        backgroundColor: "rgba(220,220,220,0.5)"
                    },{
                        label: 'New',
                        data: [<?php echo '"'.implode('","', $data_new).'"'; ?>],
                        fillColor : "rgba(151,187,205,0.5)",
                        strokeColor : "rgba(151,187,205,1)",
                        pointColor : "rgba(151,187,205,1)",
                        pointStrokeColor : "#fff",
                        backgroundColor: "rgba(151,187,205,0.5)"
                    }]
                }
            });
        </script>
        <?php
    }

    public function get_stats_by_week($post_type = 'gd_place', $week_type = 'this_week', $count_type = "new", $is_review = false) {
        $days = array();
        $dates = array();

        if ($week_type == 'this_week') {

            $this_week_dates = array('7','6','5','4','3','2','1');
            foreach ($this_week_dates as $date) {
                $days[] = date('D', strtotime("-".$date." day"));
                $dates[] = date('Y-m-d H:i:s', strtotime("-".$date." day"));
            }
        } else {
            $last_week_dates = array('14','13','12','11','10','9','8');
            foreach ($last_week_dates as $date) {
                $days[] = date('D', strtotime("-".$date." day"));
                $dates[] = date('Y-m-d H:i:s', strtotime("-".$date." day"));
            }
        }


        $counts = array();
        foreach ($dates as $date) {
            if ($count_type == 'new') {
                $counts[] = $this->counts->count_by_week_new($post_type, $date, $is_review);
            } else {
                $counts[] = $this->counts->count_by_date_total($post_type, $date, $is_review);
            }

        }

        $values = array_combine($days, $counts);

        return $values;
    }

    public function get_stats_by_month($post_type = 'gd_place', $year_type = 'this_month', $count_type = "new", $is_review = false) {

        if ($year_type == 'this_month') {
            $month = date('m');
            $year = date('Y');
        } else {
            $month = date('m', strtotime("-1 month"));
            $year = date('Y', strtotime("-1 month"));
        }

        $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));

        $days = array();

        for ($d=1; $d<=$days_in_month; $d++) {

            $days[$d] = array(
                'start' => date('Y-m-d H:i:s', mktime(0,0,0,$month, $d, $year)),
                'end' => date('Y-m-d H:i:s', mktime(23,59,59,$month, $d, $year)),
            );
        }
        
        $counts = array();
        foreach ($days as $key => $date) {
            if ($count_type == 'new') {
                $counts[$key] = $this->counts->count_by_range_new($post_type, $date['start'], $date['end'], $is_review);
            } else {
                $counts[$key] = $this->counts->count_by_date_total($post_type, $date['end'], $is_review);
            }

        }

        return $counts;
    }

    public function get_stats_by_year($post_type = 'gd_place', $year_type = 'this_year', $count_type = "new", $is_review = false) {

        if ($year_type == 'this_year') {
            $year = date('Y');
        } else {
            $year = date('Y', strtotime("-1 year"));
        }

        $months = array();

        for ($m=1; $m<=12; $m++) {
            $month = date('M', mktime(0,0,0,$m, 1, $year));

            $months[$month] = array(
                'start' => date('Y-m-d H:i:s', mktime(0,0,0,$m, 1, $year)),
                'end' => date('Y-m-t H:i:s', mktime(23,59,59,$m, 1, $year)),
            );
        }

        $counts = array();
        foreach ($months as $key => $date) {
            if ($count_type == 'new') {
                $counts[$key] = $this->counts->count_by_range_new($post_type, $date['start'], $date['end'], $is_review);
            } else {
                $counts[$key] = $this->counts->count_by_date_total($post_type, $date['end'], $is_review);
            }

        }

        return $counts;
    }

    public function generate_chart_js($type = 'line', $labels = array(), $data = array(), $id = 'gdDashListings') {
        ?>
<!--        <div class="gd-chart-wrap">-->
            <canvas id="<?php echo $id; ?>"></canvas>
<!--        </div>-->
        <script type="text/javascript">
            var ctx = document.getElementById('<?php echo $id; ?>').getContext('2d');
            var myChart = new Chart(ctx, {
                type: '<?php echo $type; ?>',
                data: {
                    labels: [<?php echo '"'.implode('","', $labels).'"'; ?>],
                    datasets: [{
                        label: '# of Items',
                        data: [<?php echo '"'.implode('","', $data).'"'; ?>],
                        fillColor : "rgba(151,187,205,0.5)",
                        strokeColor : "rgba(151,187,205,1)",
                        pointColor : "rgba(151,187,205,1)",
                        pointStrokeColor : "#fff",
                        backgroundColor: "rgba(151,187,205,0.5)"
                    }]
                }
            });
        </script>
        <?php
    }
}