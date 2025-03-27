<?php
/**
 * All modules.
 *
 * @package LSAD\Modules;
 */

namespace LSAD\Modules;

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Direct access forbidden.' );
}

use LSAD\Modules\LanguageSwitcherModule\LanguageSwitcherModule;

add_action(
    'divi_module_library_modules_dependency_tree',
    function( $dependency_tree ) {
      $dependency_tree->add_dependency( new LanguageSwitcherModule() );
    }
);