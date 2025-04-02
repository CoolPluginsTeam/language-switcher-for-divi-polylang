<?php
/**
 * REST Registration.
 *
 * @package LSAD\Modules;
 */

namespace LSAD\Modules;

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Direct access forbidden.' );
}

use ET\Builder\Framework\Route\RESTRoute;
use LSAD\Modules\LanguageSwitcherModule\LanguageSwitcherModuleController;

/**
 * Class RESTRegistration
 *
 * @package LSAD\Modules
 */
class RESTRegistration {
  /**
   * Register REST routes for modules.
   */
  public function register_routes() {
    $route = new RESTRoute( 'lsad/v1' ); // Namespace for the extension.

    // Route for Language Switcher Module.
    $route->prefix('/module-data')->get( '/language-switcher-module', LanguageSwitcherModuleController::class );
  }
}