<?php
/**
Plugin Name: Language Switcher for Polylang – Elementor, Gutenberg, & Divi
Plugin URI:  https://wordpress.org/plugins/language-switcher-for-divi-polylang
Description: Language Switcher for Polylang – Elementor, Gutenberg, & Divi to use added language switcher in your page or divi header menu
Version:     1.0.7
Requires at least: 5.0
Requires PHP: 7.2
Author:      Coolplugins
Author URI:  https://coolplugins.net/?utm_source=lspd_plugin&utm_medium=inside&utm_campaign=author_page&utm_content=plugins_list
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: language-switcher-for-divi-polylang
Requires Plugins: polylang

Language Switcher for Polylang – Elementor, Gutenberg, & Divi is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Language Switcher for Polylang – Elementor, Gutenberg, & Divi is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Language Switcher for Polylang – Elementor, Gutenberg, & Divi. If not, see https://www.gnu.org/licenses/gpl-2.0.html.

 * @package LanguageSwitcherForDiviPolylang
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LSDP', '1.0.7' );
define( 'LSDP_DIR', plugin_dir_path( __FILE__ ) );
define( 'LSDP_URL', plugin_dir_url( __FILE__ ) );
define( 'LSDP_MODULE_URL', LSDP_URL . 'includes/modules' );
define( 'LSDP_MODULE_DIR', LSDP_DIR . 'includes/modules' );
define( 'LSDP_FEEDBACK_API', 'https://feedback.coolplugins.net/' );

/**
 * Main plugin bootstrap.
 */
final class LANGUAGE_SWITCHER_FOR_DIVI_POLYLANG {

	/**
	 * Singleton instance.
	 *
	 * @var self|null
	 */
	private static $instance = null;

	/** Register hooks. */
	private function __construct() {

		add_action( 'plugins_loaded', array( $this, 'init' ), 20 );
		add_action( 'admin_init', array( $this, 'redirect_after_activation' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
		add_action( 'divi_extensions_init', array( $this, 'initialize_divi_4' ) );
		add_filter( 'et_fb_backend_helpers', array( $this, 'localize_divi_data' ) );
	}
	/** Activation defaults. */
	public static function activate() {
		update_option( 'lsdp-v', LSDP );
		update_option( 'lsdp-type', 'FREE' );
		if ( ! get_option( 'lsdp_initial_save_version' ) ) {
			add_option( 'lsdp_initial_save_version', LSDP );
			add_option( 'lsdp_plugin_activation_redirect', true );
		}
		if ( ! get_option( 'lsdp-installDate' ) ) {
			add_option( 'lsdp-installDate', gmdate( 'Y-m-d H:i:s' ) );
		}
	}

	/** Load builder-independent features and optional integrations. */
	public function init() {
		require_once LSDP_DIR . 'helpers/class-lsdp-common-helpers.php';
		require_once LSDP_DIR . 'helpers/lsdp-block-helpers.php';

		if ( ! LSDP_Common_Helpers::is_dependencies_active() ) {
			add_action( 'admin_notices', array( $this, 'polylang_notice' ) );
			return;
		}

		// Divi builds its native module dependency tree while the theme loads.
		// Register these hooks now, before after_setup_theme, so Divi 5 can find them.
		$this->initialize_divi_5();
		require_once LSDP_DIR . 'includes/class-lsdp-language-switcher-block.php';
		LSDP_Language_Switcher_Block::get_instance();

		if ( LSDP_Common_Helpers::is_elementor_available() ) {
			require_once LSDP_DIR . 'includes/class-lsdp-manager.php';
			require_once LSDP_DIR . 'includes/class-lsdp-register-widget.php';
		}

		if ( is_admin() ) {
			require_once LSDP_DIR . 'admin/class-lsdp-floating-switcher-settings.php';
			LSDP_Floating_Switcher_Settings::get_instance();
			require_once LSDP_DIR . 'admin/feedback/class-lsdp-feedback.php';
			require_once LSDP_DIR . 'admin/dashboard/class-lsdp-admin-dashboard.php';
			lsdp_register_admin_dashboard();
		} else {
			require_once LSDP_DIR . 'includes/class-lsdp-floating-switcher-frontend.php';
		}
	}

	/** Load the Divi 4 extension only when Divi fires its integration hook. */
	public function initialize_divi_4() {
		$divi_version = self::get_divi_theme_version();
		if ( $divi_version && version_compare( (string) $divi_version, '5.0', '<' ) ) {
			if ( file_exists( LSDP_DIR . 'includes/LanguageSwitcherForDiviPolylang.php' ) ) {
				require_once LSDP_DIR . 'includes/LanguageSwitcherForDiviPolylang.php';
			}
		}
	}

	/** Register optional Divi 5 support before the theme builds its module tree. */
	public function initialize_divi_5() {
		$divi_version = self::get_divi_theme_version();
		if ( $divi_version && version_compare( (string) $divi_version, '5.0', '>=' ) ) {
			require_once LSDP_DIR . 'divi-5/divi-5.php';
			new LSDP_Divi5();
		}
	}

	/**
	 * Supply language data to the Divi visual builder.
	 *
	 * @param array $data Existing visual builder data.
	 * @return array
	 */
	public function localize_divi_data( $data ) {
		if ( ! function_exists( 'et_core_is_fb_enabled' ) || ! et_core_is_fb_enabled() || ! function_exists( 'pll_the_languages' ) ) {
			return $data;
		}

		$languages = pll_the_languages( array( 'raw' => 1 ) );
		if ( empty( $languages ) || ! is_array( $languages ) ) {
			return $data;
		}

		$data['lsdpGlobalObj'] = array(
			'lsdpLanguageData' => array_map(
				static function ( $language ) {
					return array(
						'flagCode'       => LSDP_Common_Helpers::get_flag_code( $language['flag'] ),
						'slug'           => sanitize_key( $language['slug'] ),
						'name'           => sanitize_text_field( $language['name'] ),
						'no_translation' => ! empty( $language['no_translation'] ),
						'url'            => esc_url_raw( $language['url'] ),
					);
				},
				$languages
			),
			'lsdpCurrentLang'  => function_exists( 'pll_current_language' ) ? sanitize_key( pll_current_language() ) : '',
			'lsdpPluginUrl'    => esc_url_raw( LSDP_URL ),
		);

		return $data;
	}

	/** Show the sole dependency notice. */
	public function polylang_notice() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'Language Switcher for Polylang requires Polylang to be installed and activated.', 'language-switcher-for-divi-polylang' ) . '</p></div>';
	}

	/** Redirect once after activation. */
	public function redirect_after_activation() {
		if ( ! get_option( 'lsdp_plugin_activation_redirect', false ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}
		delete_option( 'lsdp_plugin_activation_redirect' );
		wp_safe_redirect( admin_url( 'admin.php?page=lsdp-get-started' ) );
		exit;
	}

	/**
	 * Add the dashboard link on the Plugins screen.
	 *
	 * @param array $links Existing plugin action links.
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=lsdp-get-started' ) ) . '">' . esc_html__( 'Get Started', 'language-switcher-for-divi-polylang' ) . '</a>';
		return $links;
	}

	/** Get singleton. */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Get Divi theme version.
	 *
	 * @since 1.2.4
	 * @return string Divi theme version.
	 */
	public static function get_divi_theme_version() {
		if ( ! self::is_divi_theme_active( 'Divi' ) ) {
			return 0;
		}

		$theme = wp_get_theme();

		// When active theme is a child of Divi, use the parent (Divi) theme version.
		if ( $theme->parent() ) {
			return $theme->parent()->get( 'Version' );
		}

		return $theme->get( 'Version' );
	}

	/**
	 * Check if Divi theme is active.
	 *
	 * @since 1.2.4
	 * @return bool True if Divi theme is active.
	 */
	public static function is_divi_theme_active( $target ) {
		$theme = wp_get_theme();

		if (
			$theme->get( 'Name' ) === $target ||
			stripos( $theme->get( 'Template' ), $target ) !== false ||
			( $theme->parent() && stripos( $theme->parent()->get( 'Name' ), $target ) !== false )
		) {
			return true;
		}

		if ( apply_filters( 'divi_ghoster_ghosted_theme', '' ) === $target ) {
			return true;
		}

		return false;
	}
}

register_activation_hook( __FILE__, array( 'LANGUAGE_SWITCHER_FOR_DIVI_POLYLANG', 'activate' ) );
LANGUAGE_SWITCHER_FOR_DIVI_POLYLANG::get_instance();
