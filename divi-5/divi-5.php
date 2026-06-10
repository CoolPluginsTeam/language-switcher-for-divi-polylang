<?php

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Direct access forbidden.' );
}
// Require php files.
require_once LSDP_DIR . 'divi-5/vendor/autoload.php';
require_once LSDP_DIR . 'divi-5/server/Modules/Modules.php';


class LSDP_Divi5 {
  public function __construct() {
    add_action( 'divi_visual_builder_assets_before_enqueue_scripts', array( $this, 'enqueue_visual_builder_assets' ) );
    add_action('admin_enqueue_scripts', [$this, 'enqueue_frontend_assets'], 5);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets'], 5);
  }

  /**
   * Enqueue Frontend Assets
   *
   * @since 1.0.0
   */
  function enqueue_frontend_assets() {
    wp_enqueue_style( 'lsdp-divi5-frontend-style', LSDP_URL . 'styles/style.min.css', [], LSDP );
    wp_enqueue_style( 'lsdp-divi5-frontend-helper', LSDP_URL . 'assets/css/lsdphelper.css', [], LSDP );
    if(!et_core_is_fb_enabled()){
			wp_enqueue_script( 'lsdp-module-js', LSDP_URL . 'assets/js/lsdp_module_frontend.js', [], LSDP, true );
		}
  }

  /**
   * Enqueue Divi 5 Visual Builder Assets
   *
   * @since 1.0.0
   */
  function enqueue_visual_builder_assets() {
    // wp_enqueue_script('lsdp-divi5-visual-builder-script', LSDP_URL . 'divi-5/visual-builder/build/language-switcher-for-divi-polylang-build.js',[], LSDP, true);
    \ET\Builder\VisualBuilder\Assets\PackageBuildManager::register_package_build(
      [
        'name'   => 'lsdp-divi5-visual-builder-script',
        'version' => LSDP,
        'script' => [
          'src' => LSDP_URL . 'divi-5/visual-builder/build/language-switcher-for-divi-polylang-build.js',
          'deps'               => [
            'divi-module-library',
            'divi-vendor-wp-hooks',
            'react',
            'jquery-core',
            'divi-rest',
            'wp-hooks',
          ],
          'enqueue_top_window' => false,
          'enqueue_app_window' => true,
        ],
      ]
    );
}  

}
