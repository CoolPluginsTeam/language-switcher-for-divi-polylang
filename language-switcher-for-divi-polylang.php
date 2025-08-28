<?php
/*
Plugin Name: Language Switcher – Polylang for Divi
Plugin URI:  https://wordpress.org/plugins/language-switcher-for-divi-polylang
Description: Language Switcher – Polylang for Divi to use added language switcher in your page or divi header menu
Version:     1.0.2
Requires at least: 5.0
Requires PHP: 7.2
Author:      Coolplugins
Author URI:  https://coolplugins.net/?utm_source=lspd_plugin&utm_medium=inside&utm_campaign=author_page&utm_content=plugins_list
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: language-switcher-for-divi-polylang
Requires Plugins: polylang

Language Switcher – Polylang for Divi is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Language Switcher – Polylang for Divi is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Language Switcher – Polylang for Divi. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/
if ( ! defined( 'ABSPATH' ) ) {
  die( 'Direct access forbidden.' );
}

define( 'LSDP', '1.0.2' );
define( 'LSDP_DIR', plugin_dir_path( __FILE__ ) );
define( 'LSDP_URL', plugin_dir_url( __FILE__ ) );
define( 'LSDP_MODULE_URL', plugin_dir_url( __FILE__ ) . 'includes/modules' );
define( 'LSDP_MODULE_DIR', plugin_dir_path( __FILE__ ) . 'includes/modules' );

if ( ! class_exists( 'LANGUAGE_SWITCHER_FOR_DIVI_POLYLANG' ) ) {
	class LANGUAGE_SWITCHER_FOR_DIVI_POLYLANG {
		public static $instance;

		public function __construct() {
			
			register_activation_hook( __FILE__, array( $this, 'lsdp_activate' ) );
			add_action( 'plugins_loaded', array( $this, 'lsdp_init' ) );
			add_action( 'admin_init', array( $this, 'is_divi_theme_exist' ) );
			add_action( 'divi_extensions_init', array( $this, 'initialize_divi_module' ) );
			add_filter( 'et_fb_backend_helpers', array( $this, 'lsdp_localize_polyglang_data' ) );
			self::initialize_divi_5_module();
		}

		public function lsdp_activate() {
			update_option( 'lsdp-v', LSDP );
			update_option( 'lsdp-type', 'FREE' );
			update_option( 'lsdp-installDate', gmdate( 'Y-m-d h:i:s' ) );
			update_option( 'lsdp-ratingDiv', 'no' );
			if (!get_option( 'lsdp_initial_save_version' ) ) {
                add_option( 'lsdp_initial_save_version', LSDP );
				add_option( 'lsdp_plugin_activation_redirect', true );
            }
		}

		public function lsdp_init() {
			global $polylang;
			if ( ! isset( $polylang ) ) {
				add_action( 'admin_notices', array( self::$instance, 'lsdp_plugin_required_admin_notice' ) );
			}
			if ( is_admin() ) {
				
				/** Feedback form after deactivation */
				require_once __DIR__ . '/admin/feedback/admin-feedback-form.php';
				/*** Plugin review notice file */
				require_once __DIR__ . '/admin/lsdp-feedback-notice.php';
				new LSDPFeedbackNotice();
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
					// translators: 1: Plugin Name, 2: Theme Name
					esc_html__(
						'%1$s requires %2$s to be installed and activated.',
						'language-switcher-for-divi-polylang'
					),
					esc_html__( 'Language Switcher – Polylang for Divi', 'language-switcher-for-divi-polylang' ),
					esc_html__( 'Divi (Theme)', 'language-switcher-for-divi-polylang' )
				);
				echo sprintf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', esc_html( $message ) );
				if ( function_exists( 'deactivate_plugins' ) ) {
					deactivate_plugins( __FILE__ );
			  	}
			}
		}

		public function lsdp_plugin_required_admin_notice() {
			if ( current_user_can( 'activate_plugins' ) ) {
				$url         = 'plugin-install.php?tab=plugin-information&plugin=polylang&TB_iframe=true';
				$title       = 'Polylang';
				$plugin_info = get_plugin_data( __FILE__, true, true );
				echo '<div class="error"><p>' .
				sprintf(
					// translators: 1: Plugin Name, 2: Plugin URL
					esc_html__(
						'In order to use %1$s plugin, please install and activate the latest version  of %2$s',
						'language-switcher-for-divi-polylang'
					),
					wp_kses( '<strong>' . esc_html( $plugin_info['Name'] ) . '</strong>', 'strong' ),
					wp_kses( '<a href="' . esc_url( $url ) . '" class="thickbox" title="' . esc_attr( $title ) . '">' . esc_html( $title ) . '</a>', 'a' )
				) . '.</p></div>';

				if ( function_exists( 'deactivate_plugins' ) ) {
					  deactivate_plugins( __FILE__ );
				}
			}
		}

		public function lsdp_localize_polyglang_data( $data ) {
			// return $data;
			global $polylang;
			$lsdp_polylang = $polylang;

			if ( isset( $lsdp_polylang ) ) {
				if ( function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() ) {
					try {
						require_once LSDP_DIR . 'helpers/class-lsdp-helpers.php';
						if ( function_exists( 'pll_the_languages' ) && function_exists( 'pll_current_language' ) ) {
							$languages = pll_the_languages( array( 'raw' => 1 ) );
							if ( empty( $languages ) ) {
								return $data; // If no languages, exit early
							}
							$lang_curr = strtolower( pll_current_language() );

							$languages = array_map(
								function( $language ) {
									return $language['name'] = array(
										'flagCode'       => esc_html( LSDP_HELPERS::get_flag_code( $language['flag'] ) ),
										'slug'           => esc_html( $language['slug'] ),
										'name'           => esc_html( $language['name'] ),
										'no_translation' => esc_html( $language['no_translation'] ),
										'url'            => esc_url( $language['url'] ),
									);
								},
								$languages
							);

							$custom_data = array(
								'lsdpLanguageData' => $languages,
								'lsdpCurrentLang'   => esc_html( $lang_curr ),
								'lsdpPluginUrl'     => esc_url( LSDP_URL ),
							);
							$custom_data_json = $custom_data;

							$data['lsdpGlobalObj'] = $custom_data_json;
						}
					} catch ( Exception $e ) {
						// Handle exception if needed
					}
				}
			}
			return $data;
		}

		public function initialize_divi_5_module(){
			if (wp_get_theme()->get('Version') >= 5) {
				require_once plugin_dir_path( __FILE__ ) . 'divi-5/divi-5.php';
				new LSDP_Divi5();
			}
		}
		public function initialize_divi_module() {
			require_once plugin_dir_path( __FILE__ ) . 'includes/LanguageSwitcherForDiviPolylang.php';
		}

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
	}

	LANGUAGE_SWITCHER_FOR_DIVI_POLYLANG::get_instance();
}

