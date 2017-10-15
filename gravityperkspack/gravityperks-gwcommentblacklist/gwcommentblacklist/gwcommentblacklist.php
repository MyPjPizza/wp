<?php

/**
* Plugin Name: GP Comment Blacklist
* Description: Validate your form against your WordPress comment blacklist.
* Plugin URI: http://gravitywiz.com/
* Version: 1.1
* Author: David Smith
* Author URI: http://gravitywiz.com/
* License: GPL2
* Perk: True
*/

/**
* Saftey net for individual perks that are active when core Gravity Perks plugin is inactive.
*/
$gw_perk_file = __FILE__;
if(!require_once(dirname($gw_perk_file) . '/safetynet.php'))
    return;

class GWCommentBlacklist extends GWPerk {

	public $version = '1.1';

	public $form_id;
	public $form_meta;

	public function init() {

		$this->add_tooltip( $this->key( 'form_tooltip' ),  __( '<h6>Validate Against WP Comment Blacklist</h6> Enable this option to run all supported form fields through the WordPress Comment Blacklist validation.', 'gravityperks' ) );
		$this->add_tooltip( $this->key( 'field_tooltip' ), __( '<h6>Validate Against WP Comment Blacklist</h6> Enable this option to run this field through the WordPress Comment Blacklist validation.', 'gravityperks' ) );

		// Admin
		if( version_compare( GFCommon::$version, '1.8', '<' ) ) {
			$this->enqueue_form_settings();
		} else {
			add_filter( 'gform_form_settings', array( $this, 'add_form_setting' ), 10, 2 );
			add_filter( 'gform_pre_form_settings_save', array( $this, 'save_form_setting' ) );
		}

		$this->enqueue_field_settings();

		// Frontend
		add_filter( 'gform_validation', array( $this, 'validate' ) );

	}

	public function add_form_setting( $settings, $form ) {

		$settings['Restrictions']['blacklist_validation'] = sprintf( '
	        <tr>
	            <th><label for="%3$s">%1$s %2$s</label></th>
	            <td>
	            	<input value="1" type="checkbox" name="%3$s" id="%3$s" %4$s>
	            	<label for="%3$s">%5$s</label>
	            </td>
	        </tr>',
			__( 'Blacklist Validation', 'gravityperks' ),
			gform_tooltip( $this->key( 'form_tooltip' ), '', true ),
			$this->key( 'enable' ),
			checked( rgar( $form, $this->key( 'enable' ) ), true, false ),
			sprintf( __( 'Validate against WordPress %s"Comment Blacklist"%s', 'gravityperks' ), '<a href="' . admin_url( 'options-discussion.php' ) . '">', '</a>' )
		);

		return $settings;
	}

	public function save_form_setting( $form ) {
		$form[ $this->key( 'enable' ) ] = rgpost( $this->key( 'enable' ) );
		return $form;
	}

	public function validate( $validation_result ) {

        $form = $validation_result['form'];
        $ip   = GFFormsModel::get_ip();

		foreach( $form['fields'] as &$field ) {

            // if blacklisting is not enabled form wide AND if the current field does not have blacklisting enabled, skip to next field
            if( ! $this->is_form_blacklisting_enabled( $form ) && ! rgar( $field, $this->key( 'enable' ) ) ) {
	            continue;
            }

			$field_value = GFFormsModel::get_field_value($field);

            if ( is_array( $field_value ) ) {
	            $field_value = implode( ' ', $field_value );
            }

			// if the field comes back false then it means that it passed the validation, continue to the next field.
			if ( ! wp_blacklist_check( '', '', '', '', $field_value, $ip, $_SERVER['HTTP_USER_AGENT'] ) ) {
				continue;
			}

			// show that this form failed validation and why.
			$field['failed_validation']    = true;
			$field['validation_message']   = __( 'We\'re sorry, the text you entered for this field contains blacklisted words.', 'gravityperks' );
            $validation_result['is_valid'] = false;

		}

		$validation_result['form'] = $form;

		return $validation_result;
	}



	// Form Editor Settings

	public function form_settings_ui() {
		?>

        <li class="<?php echo $this->key('form_setting'); ?> form_setting">

            <input type="checkbox" id="<?php echo $this->key('form_checkbox'); ?>" value="1" onclick="gperk.setFormProperty('<?php echo $this->key('enable'); ?>', this.checked ? 1 : 0); clearFieldBlacklistSettings();">

			<label class="inline" for="<?php echo $this->key('form_checkbox'); ?>">
				<?php _e('Validate Against WP Comment Blacklist', 'gravityperks'); ?>
                <?php gform_tooltip($this->key('form_tooltip')); ?>
			</label>

		</li>

		<?php
	}

    public function form_settings_js() {
        ?>

        <script type="text/javascript">

            (function($) {

                $(document).bind('gform_load_form_settings', function(event, form) {
                    if(form['<?php echo $this->key('enable') ?>'])
                        $('#<?php echo $this->key('form_checkbox'); ?>').attr('checked', form['<?php echo $this->key('enable') ?>'] == true);
                });

            })(jQuery);

            function clearFieldBlacklistSettings() {
                for(i in form.fields) {
                    form.fields[i]['<?php echo $this->key('enable') ?>'] = false;
                }
            }

        </script>

        <?php
    }

	public function field_settings_ui() {
		?>

        <li class="<?php echo $this->key('field_setting'); ?> field_setting">

            <input type="checkbox" id="<?php echo $this->key('field_checkbox'); ?>" value="1" onclick="SetFieldProperty('<?php echo $this->key('enable'); ?>', this.checked)">

            <label class="inline" for="<?php echo $this->key('field_checkbox'); ?>">
                <?php printf( __( 'Validate against WordPress %s"Comment Blacklist"%s', 'gravityperks' ), '<a href="' . admin_url( 'options-discussion.php' ) . '">', '</a>' ); ?>
                <?php gform_tooltip( $this->key( 'field_tooltip' ) ); ?>
            </label>

        </li>

		<?php
	}

	public function field_settings_js() {
		?>

		<script type="text/javascript">
			(function($) {

				$(document).bind('gform_load_field_settings', function(event, field, form) {

                    var formEnabled = form["<?php echo $this->key('enable'); ?>"] == true;
                    var commentBlacklistSetting = $('li.<?php echo $this->key('field_setting'); ?>');;

                    if(!formEnabled && isBlacklistField(field)) {
                        commentBlacklistSetting.show();
                        $("#<?php echo $this->key('field_checkbox'); ?>").attr('checked', field["<?php echo $this->key('enable'); ?>"] == true);
                    } else {
                        commentBlacklistSetting.hide();
                    }

				});

                function isBlacklistField(field) {
                    var commentBlacklistFields = ['text', 'textarea', 'name', 'address', 'email', 'website', 'post_title', 'post_content', 'post_excerpt', 'post_tags', 'post_category'];
                    if($.inArray(field.type, commentBlacklistFields) != -1)
                        return true;
                    if(field['inputType'] && $.inArray(field.inputType, commentBlacklistFields) != -1)
                        return true;
                    return false;
                }

			})(jQuery);

	    </script>

		<?php
	}



	// Helper Method(s)

	public function is_form_blacklisting_enabled($form) {
		return rgar($form, $this->key('enable'));
	}



    // Documentation

    public function documentation() {
        ob_start();
        ?>

# What does it do?

The **Comment Blacklist** perk allows you to validate a field's value against the WordPress Comment Blacklist validation.  This
option can be set for a single field, multiple fields **OR** all fields within a form.  If the field fails validation it will
display an error to the end user stating that their field contains blacklisted words.

# How does it work?

The perks checks to see if any fields **OR** the form, as a whole, has the Comment Blacklist setting enabled.

## Single Field

If a single field has the Comment Blacklist setting enabled then that field will take the end-users submitted value and check it
against that of the Wordpress Comment Blacklist words (See below to set these words).

## Whole Form

If the form wide Comment Blacklist setting is enabled then it loops through all fields within the form when an end-user submits the
form. It then checks the fields to see if they are supported by this perk.  After grabbing a list of all supported fields it then
validates the fields against the Wordpress Comment Blacklist words.

# How do I enable this functionality?

Since there are two options for this perk, field and form, we will do them in separate categories.

## Single Field

Navigate to "Perks" field settings by clicking the "Perks" tab within a field. Check the checkbox labeled "Validate Against WP Comment Blacklist".

![Comment Blacklist Field Setting](<?php echo $this->get_base_url(); ?>/images/field-settings.png)

## Whole Form

Navigate to the "Perks" form settings by clicking the "Perks" tab within the form settings area. Check the checkbox labeled as "Validate Against
WP Comment Blacklist".

![Comment Blacklist Form Setting](<?php echo $this->get_base_url(); ?>/images/form-settings.png)

## Setting WP Comment Blacklist Words

To specify blacklisted words, navigate to your [Discussion Settings](<?php echo admin_url('options-discussion.php'); ?>) page.
Scroll down to the "Comment Blacklist" setting and enter any words you wish to prevent from being submitted on this form.

<div class="notice">You can specify IP address in the Comment Blacklist setting and the <b>GP Comment Blacklist</b> perk will
prevent submissions from that IP.</div>

![Comment Blacklist WP Setting](<?php echo $this->get_base_url(); ?>/images/comment-blacklist-wp-setting.png)

# Anything else I need to know?

Due to the nature of Wordpress' Comment Blacklist feature it will match words inside of other words.So lets say you wanted
to ban the word **Race** it would also ban any words with race in it, like **Racer**.

That's pretty much it. If you have any questions on this functionality or just want to say how much you love it, make sure you
come back to [GravityWiz.com](<?php echo $this->data['AuthorURI'] ?>) and leave us a comment.

[Visit this Perk's Home Page](<?php echo $this->data['PluginURI'] ?>)

        <?php
        return ob_get_clean();
    }
}