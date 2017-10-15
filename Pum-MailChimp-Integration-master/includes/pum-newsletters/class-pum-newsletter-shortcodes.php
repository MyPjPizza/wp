<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class that handles the shortcode for the extension
 *
 * @package     PopMake\Pum_MailChimp_Integration\PUM_Newsletter_Shortcodes
 * @since 1.0.0
 */
class PUM_Newsletter_Shortcodes {

	/**
	 * Attaches the functions to the hooks or shortcodes
	 *
	 * @since 1.0.0
	 * @return void
	 * @access public
	 */
	public static function init() {
		add_shortcode( 'pum_sub_form', array( 'PUM_Newsletter_Shortcodes', 'generate_shortcode' ) );
	}

	/**
	 * Generates the shortcode content
	 *
	 * @access public
	 * @since 1.0.0
	 * @return string The html or text to replace the shortcode
	 */
	public static function generate_shortcode( $atts ) {

		//normal extract
		$atts = shortcode_atts(array(
			'service' => 'none',
			'button_text' => 'Subscribe',
			'name_text' => 'Name',
			'email_text' => 'Email',
			'layout' => 'block',
			'style' => 'default'
		), $atts, 'pum_sub_form');

		extract( $atts );
		ob_start();

		$classes = array( 'pum_sub_form', $service, $layout, $style );

		//generate the subscribe forms
		?>
		<form class="<?php echo implode( ' ', $classes ); ?>">
			<p class="pum-newsletter-error-msg"></p>
			<div class="sub_form_name_div">
				<label class="sub_form_label"><?php echo $name_text; ?></label>
				<input type="text" class="sub_form_name" name="name">
			</div>
			<div class="sub_form_email_div">
				<label class="sub_form_label"><?php echo $email_text; ?></label>
				<input type="email" class="sub_form_email" name="email">
			</div>
			<?php do_action( 'pum_newsletter_fields', $atts ); ?>
			<input type="hidden" name="service" value="<?php echo $service; ?>">
			<button class="sub_form_button"><?php echo $button_text; ?></button>
		</form>
		<?php

		//return content
		return ob_get_clean();
	}
}

PUM_Newsletter_Shortcodes::init();

?>
