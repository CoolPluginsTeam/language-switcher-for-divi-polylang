<?php
/**
 * REST Registration.
 *
 * @package CPFD\Modules;
 */

namespace CPFD\Modules;

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Direct access forbidden.' );
}

use ET\Builder\Framework\Route\RESTRoute;
use CPFD\Modules\LanguageSwitcherModule\LanguageSwitcherModuleController;

/**
 * Class RESTRegistration
 *
 * @package CPFD\Modules
 */
class RESTRegistration {
  /**
   * Register REST routes for modules.
   */
  public function register_routes() {
    $route = new RESTRoute( 'cpfd/v1' ); // Namespace for the extension.

    // Route for Language Switcher Module.
    $route->prefix('/module-data')->get( '/language-switcher-module', LanguageSwitcherModuleController::class );
  }
}