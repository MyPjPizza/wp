(function ($, document) {
    "use strict";
    $(document).ready(function () {
        function trigger_check() {
            $('.distance-only, .element-only', '#scroll_general_settings').hide();

            switch ($('#scroll_general_settings').find('#trigger').val()) {
            case 'distance':
                $('.distance-only', '#scroll_general_settings').show();
                break;
            case 'element':
                $('.element-only', '#scroll_general_settings').show();
                break;
            }
        }

        $(document)
            .on('change', '#scroll_general_settings #trigger', function () { trigger_check(); })
            .on('pum_init', trigger_check);
    });
}(jQuery, document));