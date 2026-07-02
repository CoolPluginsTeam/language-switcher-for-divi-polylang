(function ($) {
    "use strict";
    $(document).ready(function () {
        $('.lsdp_dismiss_notice').on('click', function (event) {
            var thisE = $(this);
            var wrapper=thisE.parents('.lsdp-feedback-notice-wrapper');
            var ajaxURL=wrapper.data('ajax-url');
            var ajaxCallback=wrapper.data('ajax-callback');
            var nonce=wrapper.data('nonce');
            $.post(ajaxURL, { 'action':ajaxCallback, '_wpnonce':nonce }, function( data ) {
                wrapper.slideUp('fast');
            }, 'json');
        });
    });
})(jQuery);
