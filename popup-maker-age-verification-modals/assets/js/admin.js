var PUM_AVM;
(function ($, document) {
    "use strict";

    PUM_AVM = {
        _editorSelector: '#pum-shortcode-editor-pum_age_form',
        _editor: null,
        editor: function () {
            if (PUM_AVM._editor && PUM_AVM._editor.length) {
                return PUM_AVM._editor;
            }

            PUM_AVM._editor = $(PUM_AVM._editorSelector);
            return PUM_AVM._editor;
        },
        updateVisibleFields: function () {
            var which = PUM_AVM.editor().find('#pum_shortcode_attrs_type').val(),
                lockout = PUM_AVM.editor().find('#pum_shortcode_attrs_lockout_enabled').is(':checked'),
                fields = PUM_AVM.editor().find('.pum-field');

            switch (which) {
            case 'birthdate':
                fields.filter('.birthdate-only').show();
                fields.filter('.enterexit-only').hide();

                if (lockout) {
                    fields.filter('.lockout-enabled').show();
                } else {
                    fields.filter('.lockout-enabled').hide();
                }
                break;
            case 'enterexit':
                fields.filter('.enterexit-only').show();
                fields.filter('.birthdate-only').hide();
                break;
            }
        }
    };

    $(document)
        .on('click change', PUM_AVM._editorSelector + ' #pum_shortcode_attrs_lockout_enabled', PUM_AVM.updateVisibleFields)
        .on('change', PUM_AVM._editorSelector + ' #pum_shortcode_attrs_type', PUM_AVM.updateVisibleFields)
        .on('pum_init', PUM_AVM._editorSelector, PUM_AVM.updateVisibleFields);
}(jQuery, document));