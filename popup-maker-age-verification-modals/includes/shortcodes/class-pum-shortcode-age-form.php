<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_Shortcode_Age_Form
 *
 * Registers the popup_close shortcode.
 */
class PUM_Shortcode_Age_Form extends PUM_Shortcode {

	/**
	 * The shortcode tag.
	 */
	public function tag() {
		return 'pum_age_form';
	}

	public function register() {
		// register old shortcode tag.
		add_shortcode( 'age_verification', array( $this, 'handler' ) );
		parent::register();
	}

	public function label() {
		return __( 'Age Verification Form', 'popup-maker-age-verification-modals' );
	}

	public function description() {
		return __( 'A customizable Age Verification Form.', 'popup-maker-age-verification-modals' );
	}

	public function post_types() {
		return array( 'popup' );
	}

	public function sections() {
		return array(
			'general'    => __( 'General', 'popup-maker-age-verification-modals' ),
			'appearance' => __( 'Appearance', 'popup-maker-age-verification-modals' ),
			'labels'     => __( 'Labels', 'popup-maker-age-verification-modals' ),
		);
	}

	public function fields() {
		return array(
			'general'    => array(
				'type'               => array(
					'label'   => __( 'Type', 'popup-maker-age-verification-modals' ),
					'desc'    => __( 'Choose what type of age verification to use.', 'popup-maker-age-verification-modals' ),
					'type'    => 'select',
					'options' => array(
						__( 'Enter / Exit', 'popup-maker-age-verification-modals' ) => 'enterexit',
						__( 'Birthdate', 'popup-maker-age-verification-modals' )    => 'birthdate',
					),
				),
				'required_age'       => array(
					'label'   => __( 'Required Age', 'popup-maker-age-verification-modals' ),
					'desc'    => __( 'What is the required age?', 'popup-maker-age-verification-modals' ),
					'type'    => 'number',
					'std'     => 21,
					'classes' => 'birthdate-only',
					'meta'    => array(
						'required' => true,
					),
				),
				'lockout_enabled'    => array(
					'label'   => __( 'Enable lockout?', 'popup-maker-age-verification-modals' ),
					'desc'    => __( 'This will lock out users who failed verification.', 'popup-maker-age-verification-modals' ),
					'type'    => 'checkbox',
					'classes' => 'birthdate-only',
				),
				'lockout_count'      => array(
					'label'   => __( 'Lockout Try Count', 'popup-maker-age-verification-modals' ),
					'desc'    => __( 'Number of tries before getting locked out?', 'popup-maker-age-verification-modals' ),
					'type'    => 'number',
					'std'     => 3,
					'classes' => 'birthdate-only lockout-enabled',
				),
				'exit_url'           => array(
					'label'   => __( 'Exit URL', 'popup-maker-age-verification-modals' ),
					'desc'    => __( 'Enter a url to send the user to if they fail age verification.', 'popup-maker-age-verification-modals' ),
					'type'    => 'url',
					'std'     => 'http://www.disney.com',
				),
			),
			'appearance' => array(
				'form_layout'    => array(
					'label'   => __( 'Form Layout', 'popup-maker-age-verification-modals' ),
					'desc'    => __( 'Choose a form layout.', 'popup-maker-age-verification-modals' ),
					'type'    => 'select',
					'options' => array(
						__( 'Standard', 'popup-maker-age-verification-modals' ) => '',
						__( 'Vertical', 'popup-maker-age-verification-modals' ) => 'vertical',
						__( 'Inline', 'popup-maker-age-verification-modals' )   => 'inline',
						__( 'Stacked', 'popup-maker-age-verification-modals' )  => 'stacked',
					),
				),
				'form_alignment' => array(
					'label'   => __( 'Form Alignment', 'popup-maker-age-verification-modals' ),
					'desc'    => __( 'Choose how you want your form aligned.', 'popup-maker-age-verification-modals' ),
					'type'    => 'select',
					'options' => array(
						__( 'Center', 'popup-maker-age-verification-modals' ) => '',
						__( 'Left', 'popup-maker-age-verification-modals' )   => 'left',
						__( 'Right', 'popup-maker-age-verification-modals' )  => 'right',
					),
				),
				'disable_date_input' => array(
					'label'   => __( 'Disable HTML5 Date Input', 'popup-maker-age-verification-modals' ),
					'desc'    => __( 'Disables the HTML5 date input for supported browsers.', 'popup-maker-age-verification-modals' ),
					'type'    => 'checkbox',
					'classes' => 'birthdate-only',
				),
				'disable_labels'  => array(
					'label'    => __( 'Disable Labels', 'popup-maker-age-verification-modals' ),
					'desc'     => __( 'Disables the display of field labels.', 'popup-maker-age-verification-modals' ),
					'type'     => 'checkbox',
					'classes' => 'birthdate-only',
				),
			),
			'labels'     => array(
				'label_enter'     => array(
					'label'    => __( 'Enter Button', 'popup-maker-age-verification-modals' ),
					'desc'     => __( 'Label for the enter button.', 'popup-maker-age-verification-modals' ),
					'classes' => 'enterexit-only',
				),
				'label_exit'      => array(
					'label'    => __( 'Exit Button', 'popup-maker-age-verification-modals' ),
					'desc'     => __( 'Label for the exit button.', 'popup-maker-age-verification-modals' ),
					'classes' => 'enterexit-only',
				),
				'label_birthdate' => array(
					'label'    => __( 'Birth Date', 'popup-maker-age-verification-modals' ),
					'desc'     => __( 'Label for the single birthdate field.', 'popup-maker-age-verification-modals' ),
					'classes' => 'birthdate-only',
				),
				'label_month'     => array(
					'label'    => __( 'Month', 'popup-maker-age-verification-modals' ),
					'desc'     => __( 'Label for the month field.', 'popup-maker-age-verification-modals' ),
					'classes' => 'birthdate-only',
				),
				'label_day'       => array(
					'label'    => __( 'Day', 'popup-maker-age-verification-modals' ),
					'desc'     => __( 'Label for the day field.', 'popup-maker-age-verification-modals' ),
					'classes' => 'birthdate-only',
				),
				'label_year'      => array(
					'label'    => __( 'Year', 'popup-maker-age-verification-modals' ),
					'desc'     => __( 'Label for the year field.', 'popup-maker-age-verification-modals' ),
					'classes' => 'birthdate-only',
				),

			),

		);
	}

	public function defaults() {
		return array(
			'type'               => 'enterexit',
			'required_age'       => 21,
			'lockout_enabled'    => false,
			'lockout_count'      => 3,
			'exit_url'           => '',
			'disable_date_input' => false,
			'form_alignment'     => '',
			'form_layout'        => '',
			'disable_labels'     => false,
			'label_enter'        => __( 'Enter', 'popup-maker-age-verification-modals' ),
			'label_exit'         => __( 'Exit', 'popup-maker-age-verification-modals' ),
			'label_birthdate'    => __( 'Please enter your birth date.', 'popup-maker-age-verification-modals' ),
			'label_month'        => __( 'Month', 'popup-maker-age-verification-modals' ),
			'label_day'          => __( 'Day', 'popup-maker-age-verification-modals' ),
			'label_year'         => __( 'Year', 'popup-maker-age-verification-modals' ),
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
		$atts = $this->shortcode_atts( $atts );

		$data = array(
			'type'        => $atts['type'],
			'exiturl'     => $atts['exit_url'],
			'requiredage' => $atts['required_age'],
			'lockout'     => $atts['lockout_enabled'] ? $atts['lockout_count'] : null,
		);

		$data_attr = '';

		foreach ( $data as $key => $val ) {
			$data_attr .= ' data-' . $key . '="' . esc_attr( $val ) . '"';
		}

		$classes = array(
			'pum-age-form',
			'popmake-age-form',
			'align-' . ( $atts['form_alignment'] != '' ? $atts['form_alignment'] : 'center' ),
			'layout-' . ( $atts['form_layout'] != '' ? $atts['form_layout'] : 'standard' ),
		);

		$class = implode( ' ', $classes );

		ob_start(); ?>

		<div class="<?php esc_attr_e( $class ); ?>"<?php echo $data_attr; ?>><?php

		do_action( 'pum_age_form_before', $atts );

		include popmake_get_template_part( 'form-age', $atts['type'], false );

		do_action( 'pum_age_form_after', $atts ); ?>

		</div><?php

		return ob_get_clean();
	}

	public function _template() { ?>
		<script type="text/html" id="tmpl-pum-shortcode-view-<?php echo $this->tag(); ?>">
			<style>
				<?php echo readfile( PUM_AVM::$DIR . 'assets/css/site.min.css' ); ?>
			</style><!--
			<p class="pum-avm-form-desc">
				<?php printf(
					__( 'Age %s Form Placeholder', 'popup-maker-age-verification-modals' ),
					'{{ attr.type === "enterexit" ? "' . __( 'Enter / Exit' , 'popup-maker-age-verification-popups' ) . '" : "' . __( 'Birthdate' , 'popup-maker-age-verification-popups' ) . '" }}'
				); ?>
			</p>-->
			<div class='pum-age-form popmake-age-form align-<# print(typeof attr.form_alignment !== 'undefined' ? attr.form_alignment : 'center'); #> layout-<# print(typeof attr.form_layout !== 'undefined' ? attr.form_layout : 'standard'); #>' data-type="enterexit">
				<# if (attr.type === 'enterexit') { #>
				<div class='pum-age-buttons popmake-age-buttons'>

					<div class="pum-field pum-field-button pum-field-age_enter">
						<button type="button" name="enter" class="pum-age-button pum-age-enter age-enter"><# print(typeof attr.label_enter !== 'undefined' ? attr.label_enter : 'Enter'); #></button>
					</div>

					<div class="pum-field pum-field-button pum-field-age_exit">
						<button type="button" name="exit" class="pum-age-button pum-age-exit age-exit"><# print(typeof attr.label_exit !== 'undefined' ? attr.label_exit : 'Exit'); #></button>
					</div>

				</div>
				<# } else if (attr.type === 'birthdate') { #>
					<# if (typeof attr.disable_date_input === 'undefined') { #>
					<div class="date-input-enabled">
					<# } #>

						<?php echo $this->handler(array('type' => 'birthdate')); ?>

					<# if (typeof attr.disable_date_input === 'undefined') { #>
					</div>
					<# } #>
				<# } #>
			</div>
		</script><?php
	}

}

new PUM_Shortcode_Age_Form();
