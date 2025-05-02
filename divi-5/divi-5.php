<?php
// Require php files.
require_once CPFD_DIR . 'divi-5/vendor/autoload.php';
require_once CPFD_DIR . 'divi-5/server/Modules/Modules.php';


class CPFD_Divi5 {
  public function __construct() {
    add_action( 'divi_visual_builder_assets_before_enqueue_scripts', array( $this, 'enqueue_visual_builder_assets' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
  }

  /**
   * Enqueue Frontend Assets
   *
   * @since 1.0.0
   */
  function enqueue_frontend_assets() {
    wp_enqueue_style( 'cpfd-divi5-frontend-style', CPFD_URL . 'includes/modules/cpfd_module/style.css', [], CPFD );
    wp_enqueue_style( 'cpfd-divi5-frontend-helper', CPFD_URL . 'assets/css/cpfdhelper.css', [], CPFD );
    if(!et_core_is_fb_enabled()){
			wp_enqueue_script( 'cpfd-module-js', CPFD_URL . 'assets/js/cpfd_module_frontend.js', [], CPFD);
		}
  }

  /**
   * Enqueue Divi 5 Visual Builder Assets
   *
   * @since 1.0.0
   */
  function enqueue_visual_builder_assets() {
    // wp_enqueue_script('cpfd-divi5-visual-builder-script', CPFD_URL . 'divi-5/visual-builder/build/connect-polylang-for-divi-build.js',[], CPFD, true);
    \ET\Builder\VisualBuilder\Assets\PackageBuildManager::register_package_build(
      [
        'name'   => 'cpfd-divi5-visual-builder-script',
        'version' => CPFD,
        'script' => [
          'src' => CPFD_URL . 'divi-5/visual-builder/build/connect-polylang-for-divi-build.js',
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
