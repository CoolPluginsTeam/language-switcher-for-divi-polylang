(function($){
    $(document).ready(function(){
        let plugin_slug = 'language-switcher-for-divi-polylang';
        let text_domain = 'LSDP';
        
        $target = $('#the-list').find('[data-slug="'+plugin_slug+'"] span.deactivate a');
        var plugin_deactivate_link = $target.attr('href');

        let $wrapper = $("." + plugin_slug + "#cool-plugins-deactivate-feedback-dialog-wrapper");
        let $submitBtn = $("." + plugin_slug + " #cool-plugin-submitNdeactivate");
        let $skipBtn = $("." + plugin_slug + " #cool-plugin-skipNdeactivate");
        let $gdprCheckbox = $("." + plugin_slug + " #cool-plugins-GDPR-data-notice");
        let $dialogInputs = $("." + plugin_slug + " .cool-plugins-deactivate-feedback-dialog-input");
        let $loaderWrapper = $("." + plugin_slug + " #cool-plugins-loader-wrapper");
        let $wpwrap = $('#wpwrap');
        let $nonce = $("." + plugin_slug + " #_wpnonce");

        $($target).on('click', function(event){
            event.preventDefault();
            $wpwrap.css('opacity','0.4');

            $wrapper.animate({
                opacity:1
            },200,function(){
                $wrapper.removeClass('hide-feedback-popup');
                $submitBtn.addClass(text_domain);
                $skipBtn.addClass(text_domain);
            });
        });

        function updateSubmitState() {
            if($gdprCheckbox.is(":checked") === true && $dialogInputs.is(':checked') === true){ 
                $submitBtn.removeClass('button-deactivate');
            }
            else{
                $submitBtn.addClass('button-deactivate');
            }
        }

        $dialogInputs.add($gdprCheckbox).on('click', updateSubmitState);

        $wpwrap.on('click', function(ev){
            if( $wrapper.hasClass('hide-feedback-popup') === false ){
                ev.preventDefault();
                $wrapper.animate({
                    opacity:0
                },200,function(){
                    $wrapper.addClass("hide-feedback-popup");
                    $submitBtn.removeClass(text_domain);
                    $wpwrap.css('opacity','1');
                })
            }
        })

        $(document).on('click', '.' + plugin_slug + ' #cool-plugin-submitNdeactivate.'+text_domain+':not(".button-deactivate")', function(event){
            let nonce = $nonce.val();
            let reason = $dialogInputs.filter(":checked").val();
            let message = '';
            
            let $reasonTextarea = $("." + plugin_slug + " textarea[name='reason_"+reason+"']");
            if( $reasonTextarea.length>0 ){
                if( $reasonTextarea.val() == '' ){
                    alert('Please provide some extra information!');
                    return;
                }else{
                    message=$reasonTextarea.val();
                }
            }

            $.ajax({
                url:ajaxurl,
                method:'POST',
                data:{
                    'action':text_domain+'_submit_deactivation_response',
                    '_wpnonce':nonce,
                    'reason':reason,
                    'message':message,
                },
                beforeSend:function(data){
                    $submitBtn.text('Deactivating...');
                    $submitBtn.attr('id','deactivating-plugin');
                    $loaderWrapper.show();
                    $skipBtn.remove();
                },
                success:function(res){
                    $loaderWrapper.hide();
                    window.location = plugin_deactivate_link;
                    $submitBtn.text('Deactivated');
                }
            })

        });

        $(document).on('click', '.' + plugin_slug + ' #cool-plugin-skipNdeactivate.'+text_domain+':not(".button-deactivate")', function(){
            $submitBtn.remove();
            $skipBtn.addClass('button-deactivate');
            $skipBtn.attr('id','deactivating-plugin');
            window.location = plugin_deactivate_link;
        });



    });
})(jQuery);