<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'PopMake_Scroll_Triggered_Popups' ) ) {

	/**
	 * Main PopMake_Scroll_Triggered_Popups class
	 *
	 * @since       1.0.0
	 */
	class PopMake_Scroll_Triggered_Popups {

		/**
		 * @var         PopMake_Scroll_Triggered_Popups $instance The one true PopMake_Scroll_Triggered_Popups
		 * @since       1.0.0
		 */
		private static $instance;

		public $site;

		public $admin;

		/**
		 * Get active instance
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      object self::$instance The one true PopMake_Scroll_Triggered_Popups
		 */
		public static function instance() {
			if ( ! self::$instance ) {
				self::$instance = new PopMake_Scroll_Triggered_Popups();
				self::$instance->setup_constants();
				self::$instance->includes();
				self::$instance->load_textdomain();

				self::$instance->site  = new PopMake_Scroll_Triggered_Popups_Site();
				self::$instance->admin = new PopMake_Scroll_Triggered_Popups_Admin();

				self::$instance->hooks();
			}

			return self::$instance;
		}


		/**
		 * Setup plugin constants
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function setup_constants() {
			// Plugin version
			define( 'POPMAKE_SCROLLTRIGGEREDPOPUPS_VER', PUM_STP::$VER );

			// Plugin path
			define( 'POPMAKE_SCROLLTRIGGEREDPOPUPS_DIR', plugin_dir_path( __FILE__ ) );

			// Plugin URL
			define( 'POPMAKE_SCROLLTRIGGEREDPOPUPS_URL', plugin_dir_url( __FILE__ ) );
		}


		/**
		 * Include necessary files
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function includes() {
			require_once POPMAKE_SCROLLTRIGGEREDPOPUPS_DIR . 'includes/class-site.php';
			require_once POPMAKE_SCROLLTRIGGEREDPOPUPS_DIR . 'includes/class-admin.php';
			require_once POPMAKE_SCROLLTRIGGEREDPOPUPS_DIR . 'includes/admin/popups/class-metaboxes.php';
			require_once POPMAKE_SCROLLTRIGGEREDPOPUPS_DIR . 'includes/admin/popups/class-metabox-fields.php';
			require_once POPMAKE_SCROLLTRIGGEREDPOPUPS_DIR . 'includes/functions.php';
			require_once POPMAKE_SCROLLTRIGGEREDPOPUPS_DIR . 'includes/shortcodes.php';
		}


		/**
		 * Run action and filter hooks
		 */
		private function hooks() {
			// Register settings
			//add_filter( 'popmake_settings_extensions', array( $this, 'settings' ), 1 );

			add_action( 'wp_enqueue_scripts', array( $this->site, 'scripts' ) );
			add_filter( 'popmake_get_the_popup_classes', array( $this->site, 'popup_classes' ), 5, 2 );
			add_filter( 'popmake_get_the_popup_data_attr', array( $this->site, 'popup_data_attr' ), 10, 2 );
			add_filter( 'popmake_enqueue_scripts', array( $this->site, 'enqueue_scripts' ), 10, 2 );

			add_action( 'admin_enqueue_scripts', array( $this->admin, 'scripts' ), 100 );
			add_action( 'add_meta_boxes', array( $this->admin->metaboxes, 'register' ) );
			add_filter( 'popmake_popup_meta_fields', array( $this->admin->metaboxes, 'meta_fields' ) );
			add_filter( 'popmake_popup_meta_field_groups', array( $this->admin->metaboxes, 'meta_field_groups' ) );
			add_filter( 'popmake_popup_meta_field_group_scroll_triggered', array( $this->admin->metaboxes, 'group_scroll_triggered' ) );
			add_filter( 'popmake_metabox_save_popup_scroll_triggered_cookie_key', array( $this->admin->metaboxes, 'save_popup' ) );
			add_filter( 'popmake_stp_scroll_trigger_options', array( $this->admin->metaboxes, 'scroll_trigger_options' ) );
			add_filter( 'popmake_popup_scroll_triggered_defaults', array( $this->admin->metaboxes, 'scroll_triggered_defaults' ) );
			add_filter( 'popmake_scroll_triggered_size_unit_options', array( $this->admin->metaboxes, 'scroll_triggered_size_unit_options' ) );
			add_filter( 'popmake_stp_trigger_point_options', array( $this->admin->metaboxes, 'trigger_point_options' ) );

			add_action( 'popmake_popup_scroll_triggered_meta_box_fields', array( $this->admin->metabox_fields, 'enabled' ), 10 );
			add_action( 'popmake_popup_scroll_triggered_meta_box_fields', array( $this->admin->metabox_fields, 'trigger' ), 20 );
			add_action( 'popmake_popup_scroll_triggered_meta_box_fields', array( $this->admin->metabox_fields, 'distance' ), 30 );
			add_action( 'popmake_popup_scroll_triggered_meta_box_fields', array( $this->admin->metabox_fields, 'trigger_element' ), 40 );
			add_action( 'popmake_popup_scroll_triggered_meta_box_fields', array( $this->admin->metabox_fields, 'trigger_point' ), 50 );
			add_action( 'popmake_popup_scroll_triggered_meta_box_fields', array( $this->admin->metabox_fields, 'close_on_up' ), 60 );
			add_action( 'popmake_popup_scroll_triggered_meta_box_fields', array( $this->admin->metabox_fields, 'cookie_trigger' ), 70 );
			add_action( 'popmake_popup_scroll_triggered_meta_box_fields', array( $this->admin->metabox_fields, 'cookie_time' ), 80 );
			add_action( 'popmake_popup_scroll_triggered_meta_box_fields', array( $this->admin->metabox_fields, 'cookie_path' ), 90 );
			add_action( 'popmake_popup_scroll_triggered_meta_box_fields', array( $this->admin->metabox_fields, 'cookie_key' ), 100 );

			// Handle licensing
			if ( class_exists( 'PopMake_License' ) ) {
				$license = new PopMake_License( __FILE__, 'Scroll Triggered Popups', POPMAKE_SCROLLTRIGGEREDPOPUPS_VER, 'WP Popup Maker' );
			}
		}

		/**
		 * Internationalization
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      void
		 */
		public function load_textdomain() {
			// Set filter for language directory
			$lang_dir = POPMAKE_SCROLLTRIGGEREDPOPUPS_DIR . '/languages/';
			$lang_dir = apply_filters( 'popmake_stp_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'popup-maker-scroll-triggered-popups' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'popup-maker-scroll-triggered-popups', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/popup-maker/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				load_textdomain( 'popup-maker-scroll-triggered-popups', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				load_textdomain( 'popup-maker-scroll-triggered-popups', $mofile_local );
			} else {
				load_plugin_textdomain( 'popup-maker-scroll-triggered-popups', false, $lang_dir );
			}
		}


		/**
		 * Add settings
		 *
		 * @access      public
		 * @since       1.0.0
		 *
		 * @param       array $settings The existing Popup Maker settings array
		 *
		 * @return      array The modified Popup Maker settings array
		 */
		public function settings( $settings ) {
			$new_settings = array(
				array(
					'id'   => 'popmake_stp_settings',
					'name' => '<strong>' . __( 'Scroll Triggered Popups Settings', 'popup-maker-scroll-triggered-popups' ) . '</strong>',
					'desc' => __( 'ConfigureScroll Triggered Popups Settings', 'popup-maker-scroll-triggered-popups' ),
					'type' => 'header',
				)
			);

			return array_merge( $settings, $new_settings );
		}
	}
} // End if class_exists check


function PopMake_Scroll_Triggered_Popups() {
	return PopMake_Scroll_Triggered_Popups::instance();
}
