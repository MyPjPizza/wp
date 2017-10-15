(function ($) {
    "use strict";

    var PUM_ALM = {
        init: function () {
            if ($('#pum-shortcode-editor-pum_login_form, #pum-shortcode-editor-pum_registration_form, #pum-shortcode-editor-pum_recovery_form').length) {
                PUM_ALM.toggle_redirect();
                PUM_ALM.toggle_autoclose();
                PUM_ALM.toggle_labels();
                PUM_ALM.toggle_placeholders();
                PUM_ALM.toggle_rememberme();
            }
        },
        toggle_redirect: function () {
            var field = $('#pum_shortcode_attrs_disable_redirect'),
                toggle = $('.pum_shortcode_attrs_redirect-wrapper');

            if (field.is(':checked')) {
                toggle.hide();
            } else {
                toggle.show();
            }
        },
        toggle_autoclose: function () {
            var field = $('#pum_shortcode_attrs_autoclose'),
                toggle = $('.pum_shortcode_attrs_close_delay-wrapper');

            if (field.is(':checked')) {
                toggle.show();
            } else {
                toggle.hide();
            }
        },
        toggle_labels: function () {
            var field = $('#pum_shortcode_attrs_disable_labels'),
                toggle = $('.pum_shortcode_attrs_label_username-wrapper, .pum_shortcode_attrs_label_password-wrapper, .pum_shortcode_attrs_label_email-wrapper, .pum_shortcode_attrs_label_confirm_email-wrapper, .pum_shortcode_attrs_label_confirm_password-wrapper, .pum_shortcode_attrs_label_submit-wrapper');

            if (field.is(':checked')) {
                toggle.hide();
            } else {
                toggle.show();
            }

            if ($('#pum-shortcode-editor-pum_login_form').length) {
                PUM_ALM.toggle_rememberme();
            }

            if ($('#pum-shortcode-editor-pum_registration_form').length) {
                PUM_ALM.toggle_user_passwords();
                PUM_ALM.toggle_confirm_email();
            }
        },
        toggle_placeholders: function () {
            var field = $('#pum_shortcode_attrs_disable_placeholders'),
                toggle = $('.pum_shortcode_attrs_placeholder_username-wrapper, .pum_shortcode_attrs_placeholder_password-wrapper, .pum_shortcode_attrs_placeholder_email-wrapper, .pum_shortcode_attrs_placeholder_confirm_email-wrapper, .pum_shortcode_attrs_placeholder_confirm_password-wrapper');

            if (field.is(':checked')) {
                toggle.hide();
            } else {
                toggle.show();
            }
            if ($('#pum-shortcode-editor-pum_registration_form').length) {
                PUM_ALM.toggle_user_passwords();
                PUM_ALM.toggle_confirm_email();
            }
        },
        toggle_rememberme: function () {
            var disable_labels = $('#pum_shortcode_attrs_disable_labels'),
                disable_field = $('#pum_shortcode_attrs_disable_remember'),
                toggle = $('.pum_shortcode_attrs_label_remember-wrapper');

            if (disable_labels.is(':checked') || disable_field.is(':checked')) {
                toggle.hide();
            } else {
                toggle.show();
            }
        },
        toggle_user_passwords: function () {
            var disable_labels = $('#pum_shortcode_attrs_disable_labels'),
                disable_placeholders = $('#pum_shortcode_attrs_disable_placeholders'),
                enable_password = $('#pum_shortcode_attrs_enable_password'),
                toggle = $('.pum_shortcode_attrs_enable_confirm_password-wrapper'),
                toggle_labels = $('.pum_shortcode_attrs_label_password-wrapper, .pum_shortcode_attrs_label_confirm_password-wrapper'),
                toggle_placeholders = $('.pum_shortcode_attrs_placeholder_password-wrapper, .pum_shortcode_attrs_placeholder_confirm_password-wrapper');


            if (enable_password.is(':checked')) {
                toggle.show();
            } else {
                toggle.hide();
            }



            if (disable_labels.is(':checked') || !enable_password.is(':checked')) {
                toggle_labels.hide();
            } else {
                toggle_labels.show();
            }

            if (disable_placeholders.is(':checked') || !enable_password.is(':checked')) {
                toggle_placeholders.hide();
            } else {
                toggle_placeholders.show();
            }

            PUM_ALM.toggle_confirm_password();
        },
        toggle_confirm_email: function () {
            var disable_labels = $('#pum_shortcode_attrs_disable_labels'),
                disable_placeholders = $('#pum_shortcode_attrs_disable_placeholders'),
                enable_confirm = $('#pum_shortcode_attrs_enable_confirm_email'),
                toggle_labels = $('.pum_shortcode_attrs_label_confirm_email-wrapper'),
                toggle_placeholders = $('.pum_shortcode_attrs_placeholder_confirm_email-wrapper');

            if (disable_labels.is(':checked') || !enable_confirm.is(':checked')) {
                toggle_labels.hide();
            } else {
                toggle_labels.show();
            }

            if (disable_placeholders.is(':checked') || !enable_confirm.is(':checked')) {
                toggle_placeholders.hide();
            } else {
                toggle_placeholders.show();
            }
        },
        toggle_confirm_password: function () {
            var disable_labels = $('#pum_shortcode_attrs_disable_labels'),
                disable_placeholders = $('#pum_shortcode_attrs_disable_placeholders'),
                enable_confirm = $('#pum_shortcode_attrs_enable_confirm_password'),
                toggle_labels = $('.pum_shortcode_attrs_label_confirm_password-wrapper'),
                toggle_placeholders = $('.pum_shortcode_attrs_placeholder_confirm_password-wrapper');

            if (disable_labels.is(':checked') || !enable_confirm.is(':checked')) {
                toggle_labels.hide();
            } else {
                toggle_labels.show();
            }

            if (disable_placeholders.is(':checked') || !enable_confirm.is(':checked')) {
                toggle_placeholders.hide();
            } else {
                toggle_placeholders.show();
            }
        }

    };


    $(document)
        .on('pum_init', PUM_ALM.init)
        .on('click', '#pum_shortcode_attrs_disable_redirect', PUM_ALM.toggle_redirect)
        .on('click', '#pum_shortcode_attrs_autoclose', PUM_ALM.toggle_autoclose)
        .on('click', '#pum_shortcode_attrs_disable_labels', PUM_ALM.toggle_labels)
        .on('click', '#pum_shortcode_attrs_disable_placeholders', PUM_ALM.toggle_placeholders)
        .on('click', '#pum_shortcode_attrs_enable_password', PUM_ALM.toggle_user_passwords)
        .on('click', '#pum_shortcode_attrs_enable_confirm_email', PUM_ALM.toggle_confirm_email)
        .on('click', '#pum_shortcode_attrs_enable_confirm_password', PUM_ALM.toggle_confirm_password)
        .on('click', '#pum_shortcode_attrs_disable_remember', PUM_ALM.toggle_rememberme);

}(jQuery));