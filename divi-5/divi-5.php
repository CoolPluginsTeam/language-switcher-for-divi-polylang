<?php
// Require php files.
require_once LSPAD_DIR . 'divi-5/vendor/autoload.php';
require_once LSPAD_DIR . 'divi-5/server/Modules/Modules.php';


class LSAD_Divi5 {
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
    wp_enqueue_style( 'lsad-divi5-frontend-style', LSPAD_URL . 'includes/modules/lsad_module/style.css', [], LSPAD );
  }

  /**
   * Enqueue Divi 5 Visual Builder Assets
   *
   * @since 1.0.0
   */
  function enqueue_visual_builder_assets() {
    // wp_enqueue_script('lsad-divi5-visual-builder-script', LSPAD_URL . 'divi-5/visual-builder/build/language-switcher-build.js',[], LSPAD, true);
    \ET\Builder\VisualBuilder\Assets\PackageBuildManager::register_package_build(
      [
        'name'   => 'lsad-divi5-visual-builder-script',
        'version' => 'LSPAD',
        'script' => [
          'src' => LSPAD_URL . 'divi-5/visual-builder/build/language-switcher-build.js',
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
