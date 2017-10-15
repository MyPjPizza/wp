<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class PUM_ALM_Shortcodes {

	public static function init() {
		new PUM_ALM_Shortcode_Form_Login;
		new PUM_ALM_Shortcode_Form_Registration;
		new PUM_ALM_Shortcode_Form_Recovery;
	}

}
