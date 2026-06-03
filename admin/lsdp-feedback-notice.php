<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
  }
if ( ! class_exists( 'LSDPFeedbackNotice' ) ) {
	/**
	 * Class for feedback notice.
	 */
	class LSDPFeedbackNotice {
		/**
		 * The Constructor
		 */
		public function __construct() {
			// register actions.

			if ( is_admin() ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_for_reviews' ) );
				add_action( 'wp_ajax_lsdp_dismiss_notice', array( $this, 'lsdp_dismiss_review_notice' ) );
			}
		}
		/**
		 *  Ajax callback for review notice.
		 */
		public function lsdp_dismiss_review_notice() {
            if ( ! current_user_can( 'update_plugins' ) ) {
				wp_send_json_error( 'You are not allowed to dismiss review notice' );
			}
            // Verify nonce for security
            check_ajax_referer( 'lsdp_dismiss_notice', '_wpnonce' );
            
            $rs = update_option( 'lsdp-ratingDiv', 'yes' );
            wp_send_json_success( array( 'success' => 'true' ) );
		}
		/**
		 * Admin notice.
		 */
		public function admin_notice_for_reviews() {

			if ( ! current_user_can( 'update_plugins' ) ) {
				return;
			}
			 // Get installation dates and rated settings.
			 $installation_date = get_option( 'lsdp-installDate' );
			 $already_rated     = get_option( 'lsdp-ratingDiv' ) != false ? get_option( 'lsdp-ratingDiv' ) : 'no';

			 // Check user already rated.
			if ( 'yes' === $already_rated ) {
				return;
			}

			// Grab plugin installation date and compare it with current date.
			$display_date = gmdate( 'Y-m-d h:i:s' );
			$install_date = new DateTime( $installation_date );
			$current_date = new DateTime( $display_date );
			$difference   = $install_date->diff( $current_date );
			$diff_days    = $difference->days;

			// Check if installation days is greator then week.
			if ( isset( $diff_days ) && $diff_days >= 3 ) {
				$notice_content = $this->create_notice_content();
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Content is properly escaped within create_notice_content()
				printf( '%s', $notice_content );
			}
		}
		/**
		 * Generated review notice HTML.
		 */
		public function create_notice_content() {
            $ajax_url           = admin_url( 'admin-ajax.php' );
            $ajax_callback      = 'lsdp_dismiss_notice';
            $nonce              = wp_create_nonce( 'lsdp_dismiss_notice' );
			$wrap_cls           = 'notice notice-info is-dismissible';
			$p_name             = 'Language Switcher for Divi & Polylang';
			$like_it_text       = 'Rate Now! ★★★★★';
			$already_rated_text = esc_html__( 'Already Reviewed', 'language-switcher-for-divi-polylang' );
			$not_interested     = esc_html__( 'Not Interested', 'language-switcher-for-divi-polylang' );
			$not_like_it_text   = esc_html__( 'No, not good enough, i do not like to rate it!', 'language-switcher-for-divi-polylang' );
			$p_link             = esc_url( 'https://wordpress.org/support/plugin/language-switcher-for-divi-polylang/reviews/#new-post' );
			$pro_url            = esc_url( 'https://1.envato.market/calendar' );

			$message = wp_kses_post( "Thanks for using <b>$p_name</b>. We hope it meets your expectations! <br/>Please give us a quick rating, it works as a boost for us to keep working on more <a href='https://coolplugins.net/?utm_source=plugin_dashboard&utm_medium=reviewbox' target='_blank'><strong>Cool Plugins</strong></a>!<br/>" );

			$html = '<div data-ajax-url="%7$s"  data-ajax-callback="%8$s" data-nonce="%11$s" class="lsdp-feedback-notice-wrapper %1$s">
                <div class="message_container">%3$s
                <div class="callto_action">
                <ul>
                    <li class="love_it"><a href="%4$s" class="like_it_btn button button-primary" target="_new" title="%5$s">%5$s</a></li>
                    <li class="already_rated"><a href="javascript:void(0);" class="already_rated_btn button lsdp_dismiss_notice" title="%6$s">%6$s</a></li>
                    <li class="already_rated"><a href="javascript:void(0);" class="already_rated_btn button lsdp_dismiss_notice" title="%10$s">%10$s</a></li>
                </ul>
                <div class="clrfix"></div>
                </div>
                </div>
                </div>';
                $inline_css = '<style>.lsdp-feedback-notice-wrapper.notice.notice-info.is-dismissible {
                padding: 5px;
                display: table;
                width: 100%;
                max-width: 820px;
                clear: both;
                border-radius: 5px;
            }
            .lsdp-feedback-notice-wrapper .message_container {
                display: table-cell;
                padding: 5px 20px 5px 5px;
                vertical-align: middle;
            }
            .lsdp-feedback-notice-wrapper ul li {
                float: left;
                margin: 0px 10px 0 0;
            }
            .lsdp-feedback-notice-wrapper ul li.already_rated a:before {
                color: #f12945;
                content: "\f153";
                font: normal 18px/22px dashicons;
                display: inline-block;
                vertical-align: middle;
                margin-right: 3px;
            }
            .lsdp-feedback-notice-wrapper a {
                color: #008bff;
            }
            
            /* This css is for license registration page */
            .lsdp-notice-red.uninstall {
                max-width: 700px;
                display: block;
                padding: 8px;
                border: 2px solid #157d0f;
                margin: 10px 0;
                background: #13a50b;
                font-weight: bold;
                font-size: 13px;
                color: #ffffff;
            }
            .clrfix{
                clear:both;
            }</style>';
                $inline_js  = "<script>jQuery(document).ready(function ($) {
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
            });</script>";
			$output = sprintf(
            $html,
            $wrap_cls,           // 1
            $p_name,             // 2 (not used in html)
            $message,            // 3
            $p_link,             // 4
            $like_it_text,       // 5
            $already_rated_text, // 6
            $ajax_url,           // 7
            $ajax_callback,      // 8
            $pro_url,            // 9 (not used in html)
            $not_interested,     // 10
            $nonce               // 11
        );
			$output    .= $inline_css . ' ' . $inline_js;
			return $output;
		}

	} //class end

}



