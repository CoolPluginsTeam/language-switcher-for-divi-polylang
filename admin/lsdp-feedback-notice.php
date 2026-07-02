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
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_notice_assets' ) );
			}
		}
		/**
		 *  Ajax callback for review notice.
		 */
		public function lsdp_dismiss_review_notice() {
            if ( ! current_user_can( 'update_plugins' ) ) {
				wp_send_json_error( esc_html__( 'You are not allowed to dismiss review notice', 'language-switcher-for-divi-polylang' ) );
                wp_die();
			}
            // Verify nonce for security
            check_ajax_referer( 'lsdp_dismiss_notice', '_wpnonce' );

            $rs = update_option( 'lsdp-ratingDiv', 'yes' );
            wp_send_json_success( array( 'message' => esc_html__( 'Review notice dismissed.', 'language-switcher-for-divi-polylang' ) ) );
		}

		/**
		 * Enqueue Notice Assets.
		 */
		public function enqueue_notice_assets() {
			if ( ! current_user_can( 'update_plugins' ) ) {
				return;
			}
			$installation_date = get_option( 'lsdp-installDate' );
			$already_rated     = get_option( 'lsdp-ratingDiv' ) != false ? get_option( 'lsdp-ratingDiv' ) : 'no';

			if ( 'yes' === $already_rated || ! $installation_date ) {
				return;
			}

			$display_date = gmdate( 'Y-m-d h:i:s' );
			$install_date = new DateTime( $installation_date );
			$current_date = new DateTime( $display_date );
			$difference   = $install_date->diff( $current_date );
			$diff_days    = $difference->days;

			if ( isset( $diff_days ) && $diff_days >= 3 ) {
				wp_enqueue_style( 'lsdp-review-notice-style', plugin_dir_url( __DIR__ ) . 'admin/review-notice/css/review-notice.css', array(), LSDP );
				wp_enqueue_script( 'lsdp-review-notice-script', plugin_dir_url( __DIR__ ) . 'admin/review-notice/js/review-notice.js', array( 'jquery' ), LSDP, true );
			}
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
		 * Create Notice Content.
		 */
		public function create_notice_content() {

			$plugin_slug = 'lsdp';
			$plugin_name = 'Language Switcher for Divi & Polylang';
			$plugin_link = esc_url( 'https://wordpress.org/support/plugin/language-switcher-for-divi-polylang/reviews/#new-post' );

			$message            = sprintf(
				/* translators: 1: plugin name */
				__( 'Thanks for using <b>%1$s</b>! You have used this plugin for a few days so far!<br>Please give us a quick rating, it works as a boost for us to keep working on more <a href="%2$s" target="_blank" rel="noopener"><b>Cool Plugins</b></a>!', 'language-switcher-for-divi-polylang' ),
				$plugin_name,
				esc_url( 'https://coolplugins.net/?utm_source=lspd_plugin&utm_medium=inside&utm_campaign=notice&utm_content=cool_plugins_url' )
			);
			$ajax_url           = admin_url( 'admin-ajax.php' );
			$ajax_callback      = 'lsdp_dismiss_notice';
			$like_it_text       = __( 'Rate Now! ★★★★★', 'language-switcher-for-divi-polylang' );
			$already_rated_text = __( 'Already Rated', 'language-switcher-for-divi-polylang' );
			$not_interested     = __( 'Not Interested', 'language-switcher-for-divi-polylang' );
			$p_name             = $plugin_name;
			$p_link             = $plugin_link;
			$wrap_cls           = $plugin_slug . '-feedback-notice-wrapper';
			$pro_url            = '';

			$nonce = wp_create_nonce( 'lsdp_dismiss_notice' );

			$html = '<div class="%1$s notice notice-info is-dismissible" data-ajax-url="%6$s" data-ajax-callback="%7$s" data-nonce="%9$s" style="padding: 15px;">
                <div class="message_container">
                    <p> %2$s </p>
                    <div class="lsdp_actions" style="display: flex; gap: 10px; margin-top: 10px;">
                        <a href="%3$s" class="button button-primary" target="_blank"> %4$s </a>
                        <a href="javascript:void(0);" class="button lsdp_dismiss_notice"> %5$s </a>
                        <a href="javascript:void(0);" class="button lsdp_dismiss_notice"> %8$s </a>
                    </div>
                </div>
            </div>';

			$output = sprintf(
				$html,
				$wrap_cls,           // 1
				$message,            // 2
				$p_link,             // 3
				$like_it_text,       // 4
				$already_rated_text, // 5
				$ajax_url,           // 6
				$ajax_callback,      // 7
				$not_interested,     // 8
				$nonce               // 9
			);
			return $output;
		}

	} //class end
}



