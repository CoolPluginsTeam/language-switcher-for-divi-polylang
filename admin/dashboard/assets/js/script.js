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

    function buildAddonData(btn, actionPrefix) {
        return {
            'action': actionPrefix + btn.attr('data-plugin-tag'),
            'wp_nonce': btn.attr('data-action-nonce')
        };
    }

    $('button.cool-plugins-addon').on('click', function() {
        let btn = $(this);
        let pluginSlug = btn.attr('data-plugin-slug');

        if (btn.hasClass('plugin-downloader')) {
            let data = buildAddonData(btn, 'cool_plugins_install_');
            data.polylang_slug = pluginSlug;
            doAddonAjax(data, btn, 'Installing...');
        } else if (btn.hasClass('plugin-activator')) {
            let data = buildAddonData(btn, 'cool_plugins_activate_');
            data.polylang_activate_slug = pluginSlug;
            data.polylang_activate_pluginbase = btn.attr('data-plugin-id');
            doAddonAjax(data, btn, 'Activating...');
        }
    });

    $('.plugins-list .installed-addons').each(function(el) {
        let $this = $(this);
        let message = $(this).attr('data-empty-message');

        if ($this.children('.plugin-block').length == 0) {
            $this.append('<div class="empty-message">' + message + '</div>');
        }

    })

})