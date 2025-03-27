<?php
/*
Plugin Name: Language Switcher Addon For Divi
Plugin URI:
Description: Language switcher addon for divi to use added language switcher in your page or divi header menu
Version:     1.0.0
Author:      Coolplugins
Author URI:  http://coolplugins.net/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: language-switcher-addon-for-divi
Domain Path: /languages

Language Switcher Addon For Divi is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Language Switcher Addon For Divi is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Language Switcher Addon For Divi. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

define( 'LSPAD', '1.0.0' );
define( 'LSPAD_DIR', plugin_dir_path( __FILE__ ) );
define( 'LSPAD_URL', plugin_dir_url( __FILE__ ) );
define( 'LSPAD_MODULE_URL', plugin_dir_url( __FILE__ ) . 'includes/modules' );
define( 'LSPAD_MODULE_DIR', plugin_dir_path( __FILE__ ) . 'includes/modules' );

if ( ! class_exists( 'LANGUAGE_SWITCHER_ADDON_FOR_DIVI' ) ) {
	class LANGUAGE_SWITCHER_ADDON_FOR_DIVI {
		public static $instance;

		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'lsad_init' ) );
			add_action( 'admin_init', array( $this, 'is_divi_theme_exist' ) );
			add_action( 'init', array( $this, 'lsad_load_textdomain' ) );
			add_action( 'divi_extensions_init', array( $this, 'initialize_divi_module' ) );
			add_filter( 'et_fb_backend_helpers', array( $this, 'lsad_localize_polyglang_data' ) );
		}

		public function lsad_init() {
			global $polylang;
			if ( ! isset( $polylang ) ) {
				add_action( 'admin_notices', array( self::$instance, 'lsad_plugin_required_admin_notice' ) );
			}
		}

		public function is_divi_theme_exist() {
			if ( ! self::is_theme_activate( 'Divi' ) ) {
				// Divi theme is not activated, display admin notice
				add_action( 'admin_notices', array( $this, 'admin_notice_missing_divi_theme' ) );
			}
		}

		public static function is_theme_activate( $target ) {
			$theme = wp_get_theme();
			if ( $theme->name == $target || stripos( $theme->parent_theme, $target ) !== false ) {
				return true;
			}
			if ( apply_filters( 'divi_ghoster_ghosted_theme', '' ) == $target ) {
				return true;
			}
			return false;
		}

		public function admin_notice_missing_divi_theme() {
			if ( current_user_can( 'activate_plugins' ) ) {
				$message = sprintf(
					esc_html__(
						'%1$s requires %2$s to be installed and activated.',
						'language-switcher-addon-for-divi'
					),
					esc_html__( 'Language Switcher Addon For Divi', 'language-switcher-addon-for-divi' ),
					esc_html__( 'Divi (Theme)', 'language-switcher-addon-for-divi' )
				);
				sprintf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', esc_html( $message ) );
			}
		}

		public function lsad_plugin_required_admin_notice() {
			if ( current_user_can( 'activate_plugins' ) ) {
				$url         = 'plugin-install.php?tab=plugin-information&plugin=polylang&TB_iframe=true';
				$title       = 'Polylang';
				$plugin_info = get_plugin_data( __FILE__, true, true );
				echo '<div class="error"><p>' .
				sprintf(
					// translators: 1: Plugin Name, 2: Plugin URL
					esc_html__(
						'In order to use %1$s plugin, please install and activate the latest version  of %2$s',
						'language-switcher-addon-for-divi'
					),
					wp_kses( '<strong>' . esc_html( $plugin_info['Name'] ) . '</strong>', 'strong' ),
					wp_kses( '<a href="' . esc_url( $url ) . '" class="thickbox" title="' . esc_attr( $title ) . '">' . esc_html( $title ) . '</a>', 'a' )
				) . '.</p></div>';

				if ( function_exists( 'deactivate_plugins' ) ) {
					  deactivate_plugins( __FILE__ );
				}
			}
		}

		public function lsad_localize_polyglang_data( $data ) {
			// return $data;
			global $polylang;
			$lsad_polylang = $polylang;

			if ( isset( $lsad_polylang ) ) {
				if ( function_exists( 'et_fb_enabled' ) && et_fb_enabled() ) {
					try {
						require_once LSPAD_DIR . 'helpers/class-lsad-helpers.php';
						if ( function_exists( 'pll_the_languages' ) && function_exists( 'pll_current_language' ) ) {
							$languages = pll_the_languages( array( 'raw' => 1 ) );
							if ( empty( $languages ) ) {
								return $data; // If no languages, exit early
							}
							$lang_curr = strtolower( pll_current_language() );

							$languages = array_map(
								function( $language ) {
									return $language['name'] = array(
										'flagCode'       => esc_html( LSAD_HELPERS::get_flag_code( $language['flag'] ) ),
										'slug'           => esc_html( $language['slug'] ),
										'name'           => esc_html( $language['name'] ),
										'no_translation' => esc_html( $language['no_translation'] ),
										'url'            => esc_url( $language['url'] ),
									);
								},
								$languages
							);

							$custom_data = array(
								'lsadLanguangeData' => $languages,
								'lsadCurrentLang'   => esc_html( $lang_curr ),
								'lsadPluginUrl'     => esc_url( LSPAD_URL ),
							);

							$custom_data_json = $custom_data;

							$data['lsadGlobalObj'] = $custom_data_json;
						}
					} catch ( Exception $e ) {
						// Handle exception if needed
					}
				}
			}
			return $data;
		}

		public function lsad_load_textdomain(){
			load_plugin_textdomain( 'language-switcher-addon-for-divi', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		public function initialize_divi_module() {
			require_once plugin_dir_path( __FILE__ ) . 'includes/LanguageSwitcherAddonForDivi.php';
		}

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
	}

	LANGUAGE_SWITCHER_ADDON_FOR_DIVI::get_instance();
}

