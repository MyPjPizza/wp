<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PUM_ALM_Form_User extends PUM_Form {

	public $field_name_format = '{$section}{$field}';

	public function __construct( $id, array $args ) {
		$args['sections'] = array(
			'general' => array(
				'title' => __( 'General', 'popup-maker' ),
			),
			'meta'    => array(
				'title' => __( 'User Meta', 'popup-maker' ),
			),
		);

		parent::__construct( $id, $args );
	}

	public function get_field_name( $field ) {
		return str_replace( array(
			'{$section}',
			'{$field}',
		), array(
			$field['section'] != 'general' ? $field['section'] : '',
			$field['section'] != 'general' ? "[{$field['id']}]" : $field['id'],
		), $this->field_name_format );
	}

	/**
	 * @param array $values
	 */
	function render_fields( $values = array() ) {
		foreach ( $this->get_all_fields() as $id => $args ) {
			$value = isset( $values[ $args['id'] ] ) ? $values[ $args['id'] ] : null;

			$this->render_field( $args, $value );
		}
	}

	/**
	 * @return array
	 */
	public function get_all_fields() {
		$all_fields = array();

		foreach ( $this->fields as $section => $fields ) {
			$all_fields = array_merge( $all_fields, $this->get_fields( $section ) );
		}

		uasort( $all_fields, array( $this, 'sort_by_priority' ) );

		return $all_fields;
	}


	/**
	 * Button Callback
	 *
	 * Renders buttons.
	 *
	 * @param array $args Arguments passed by the setting
	 *
	 * @return void
	 */
	public function wpsubmit_callback( $args ) {

		$args = wp_parse_args( $args, array(
			'id' => '',
			'button_type' => 'submit',
			'class' => '',
			'name' => '',
			'label' => __( 'Submit', 'popup-maker' ),
			'desc' => '',
			'size' => 'regular',
			'std' => ''
		) );

		$class = 'pum-field-button pum-field-' . $args['id'];

		if ( ! empty ( $args['class'] ) ) {
			$class .= ' ' . $args['class'];
		}

		$this->field_before( $class ); ?>

		<button type="<?php esc_attr_e( $args['button_type'] ); ?>" class="pum-button-<?php esc_attr_e( $args['size'] ); ?>" id="<?php esc_attr_e( $args['id'] ); ?>" name="<?php esc_attr_e( $args['name'] ); ?>"><?php esc_html_e( $args['label'] ); ?></button>
		<input type="hidden" name="wp-submit" value="<?php esc_attr_e( $args['std'] ); ?>" /><?php

		if ( $args['desc'] != '' ) { ?>
			<p class="pum-desc"><?php esc_html_e( $args['desc'] ); ?></p><?php
		}

		$this->field_after();
	}



	public function recaptcha_callback( $args ) {
		$key = popmake_get_option( 'google_recaptcha_site_key', false );

		if ( ! $key ) {
			return;
		}

		wp_enqueue_script( 'recaptcha' );

		$args = wp_parse_args( $args, array(
			'id' => '',
			'type' => 'recaptcha',
			'class' => '',
			'name' => '',
		) );

		$class = 'pum-field-recaptcha';

		if ( $args['type'] != 'recaptcha' ) {
			$class .= ' pum-field-' . $args['recaptcha'];
		}

		$class .= ' pum-field-' . $args['id'];

		if ( ! empty ( $args['class'] ) ) {
			$class .= ' ' . $args['class'];
		}

		$this->field_before( $class );

		?>
		<div class="g-recaptcha" data-sitekey="<?php esc_attr_e( $key ); ?>"></div>
		<?php

		$this->field_after();

	}

}
