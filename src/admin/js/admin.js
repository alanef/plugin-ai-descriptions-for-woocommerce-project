(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */
    $(function () {
        function fwas_so_settings_toggle() {
            if (ai.checked && level.value > 0) {
                document.getElementById('fwas-settings-strategy').style.display = 'table-row';
            } else {
                document.getElementById('fwas-settings-strategy').style.display = 'none';
            }
        }

        const ai = document.getElementById('ai-descriptions-for-woocommerce[ai]');
        const level = document.getElementById('ai-descriptions-for-woocommerce[level]');
        fwas_so_settings_toggle();
        [ai, level].forEach(item => {
            item.addEventListener('change', (event) => {
                fwas_so_settings_toggle();
            })
        })
    });

})(jQuery);
