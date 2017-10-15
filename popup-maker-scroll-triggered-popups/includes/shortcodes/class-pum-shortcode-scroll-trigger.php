<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_Shortcode
 *
 * This is a base class for all popup maker & extension shortcodes.
 */
class PUM_Shortcode_Scroll_Trigger extends PUM_Shortcode {

	public $has_content = false;

	/**
	 * The shortcode tag.
	 */
	public function tag() {
		return 'scroll_trigger';
	}

    public function register() {
        // register old shortcode tag.
        add_shortcode( 'scroll_pop', array( $this, 'handler' ) );
        parent::register();
    }

	public function label() {
		return __( 'Scroll Trigger', 'popup-maker-scroll-triggered-popups' );
	}

	public function description() {
		return __( 'Inserts a hidden element to trigger a scroll popup.', 'popup-maker-scroll-triggered-popups' );
	}

	public function post_types() {
		return array( 'post', 'page', 'popup' );
	}

	public function fields() {
		return array(
			'general' => array(
				'id' => array(
					'label'       => __( 'Targeted Popup', 'popup-maker-scroll-triggered-popups' ),
					'placeholder' => __( 'Choose a Popup', 'popup-maker-scroll-triggered-popups' ),
					'desc'        => __( 'Choose which popup will be targeted by this trigger.', 'popup-maker-scroll-triggered-popups' ),
					'type'        => 'postselect',
					'post_type'   => 'popup',
					'multiple'    => false,
					'as_array'    => false,
					'priority'    => 5,
					'required'    => true,
				),
			),
		);
	}

	/**
	 * Shortcode handler
	 *
	 * @param  array  $atts    shortcode attributes
	 * @param  string $content shortcode content
	 *
	 * @return string
	 */
	public function handler( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'id'      => null,
		), $atts, 'scroll_trigger' );

        if ( ! $atts['id'] ) {
            return '';
        }
        
        return '<span class="pum-stp-trigger pum-stp-trigger-' . $atts['id'] . '"></span>';
	}

	public function _template() { ?>
		<script type="text/html" id="tmpl-pum-shortcode-view-scroll_trigger">
            <span class="pum-stp-trigger pum-stp-trigger-{{attr.id}}"><small>Scroll Trigger for Popup #{{attr.id}} <small>(hidden)</small></small></span>
		</script><?php
	}

}

new PUM_Shortcode_Scroll_Trigger();
