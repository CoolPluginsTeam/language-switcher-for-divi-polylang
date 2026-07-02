jQuery(document).ready(function($) {
    function doAddonAjax(data, btn, loadingText) {
        $.ajax({
            type: 'POST',
            url: lsdp_polylang.ajax_url,
            data: data,
            beforeSend: function(res) {
                btn.text(loadingText);
            }
        })
        .done(function(res) {
            if (undefined !== res.success && false === res.success) {
                return;
            }
            window.location.reload();
        });
    }

    $('button.cool-plugins-addon').on('click', function() {
        if ($(this).hasClass('plugin-downloader')) {
            let nonce = $(this).attr('data-action-nonce');
            let nonceName = $(this).attr('data-action-name');
            let pluginTag = $(this).attr('data-plugin-tag');
            let pluginSlug = $(this).attr('data-plugin-slug');
            let btn = $(this);
            
            let data = { 'action': 'cool_plugins_install_' + pluginTag, 'wp_nonce': nonce, 'nonce_name': nonceName, 'polylang_slug': pluginSlug  };
            doAddonAjax(data, btn, 'Installing...');
        }
        if ($(this).hasClass('plugin-activator')) {
            let nonce = $(this).attr('data-action-nonce');
            let nonceName = $(this).attr('data-action-name');
            let pluginFile = $(this).attr('data-plugin-id');
            let pluginTag = $(this).attr('data-plugin-tag');
            let pluginSlug = $(this).attr('data-plugin-slug');
            let btn = $(this);
            
            let data = { 'action': 'cool_plugins_activate_' + pluginTag, 'polylang_activate_pluginbase': pluginFile, 'wp_nonce': nonce, 'nonce_name': nonceName, 'polylang_activate_slug': pluginSlug };
            doAddonAjax(data, btn, 'Activating...');
        }

    })

    $('.plugins-list .installed-addons').each(function(el) {
        let $this = $(this);
        let message = $(this).attr('data-empty-message');

        if ($this.children('.plugin-block').length == 0) {
            $this.append('<div class="empty-message">' + message + '</div>');
        }

    })

})