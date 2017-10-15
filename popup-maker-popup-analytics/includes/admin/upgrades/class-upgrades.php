<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'PopMake_Popup_Analytics_Upgrades' ) ) {

    /**
     * Main PopMake_Popup_Analytics_Upgrades class
     *
     * @since       1.1.0
     */
    class PopMake_Popup_Analytics_Upgrades {

        public function __construct() {
            add_action( 'admin_notices', array( $this, 'show_upgrade_notices' ) );
        }

        /**
         * Display Upgrade Notices
         *
         * @since 1.1.0
         * @return void
        */
        public function show_upgrade_notices() {

            if( isset( $_GET['page'] ) && $_GET['page'] == 'analytics' && isset( $_GET['popmake-action'] ) && $_GET['popmake-action'] == 'import_posttypes' ) {
                return;
            }

            $version = get_option( 'popmake_pa_version' );

            if ( ! $version ) {
                // 1.1.0 is the first version to use this option so we must add it
                $version = '1.1.0';
            }

            $version = preg_replace( '/[^0-9.].*/', '', $version );

            if ( ! get_option( 'popmake_posttypes_imported' ) ) {

                if ( wp_count_posts( 'popup_analytic_event' )->publish < 1 ) {
                    return; // No payment exist yet
                }

                printf(
                    '<div class="updated"><p>' . esc_html__( 'Your popup analytics needs to be updated, click %shere%s to start the upgrade.', 'popup-maker-popup-analytics' ) . '</p></div>',
                    '<a href="' . esc_url( admin_url( 'edit.php?post_type=popup&page=analytics&popmake-action=import_posttypes' ) ) . '">',
                    '</a>'
                );

            }

        }



        public function import_from_post_type() {
            global $wpdb;

            $analytics = get_posts( array( 'post_type' => 'popup_analytic_event', 'posts_per_page' => 2000 ) );

            $ids = array();

            foreach( $analytics as $analytic ) {

                $args = json_decode( $analytic->post_content );

                $popup_id = get_post_meta( $analytic->ID, 'popup_analytic_event_popup_id', true );
                $type     = get_post_meta( $analytic->ID, 'popup_analytic_event_type', true );

                $new_id = PopMake_Popup_Analytics()->db->insert( array(
                    'popup_id'      => $popup_id,
                    'user_id'       => $args->user_id,
                    'post_id'       => url_to_postid( $args->url ),
                    'open_event_id' => $args->open_event_id,
                    'event_type'    => $type,
                    'session_id'    => $args->session_id,
                    'trigger'       => $args->trigger,
                    'url'           => $args->url,
                ) );

                if( $new_id > 0 ) {
                    $ids[] = $analytic->ID;
                }

            }

            if( count( $ids ) ) {
                $wpdb->query("DELETE FROM $wpdb->posts WHERE ID IN (" . implode( ',', $ids ) . ")");
                $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id IN (" . implode( ',', $ids ) . ")");
            }
            $count = wp_count_posts( 'popup_analytic_event' )->publish;

            if( $count == 0 ) { 
                update_option( 'popmake_posttypes_imported', true );
            }
            return $count;
        }


    }
} // End if class_exists check