<?php
/**
 * Language Switcher Module class.
 *
 * @package LSAD\Modules\LanguageSwitcherModule;
 */

namespace LSAD\Modules\LanguageSwitcherModule;

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}

use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;
use LSAD\Modules\LanguageSwitcherModule\LanguageSwitcherModuleTraits;

/**
 * Class LanguageSwitcherModule
 *
 * @package LSAD\Modules\LanguageSwitcherModule
 */
class LanguageSwitcherModule implements DependencyInterface {
  use LanguageSwitcherModuleTraits\ModuleClassnamesTrait;
  use LanguageSwitcherModuleTraits\ModuleStylesTrait;
  use LanguageSwitcherModuleTraits\ModuleScriptDataTrait;
  use LanguageSwitcherModuleTraits\RenderCallbackTrait;
  use LanguageSwitcherModuleTraits\CustomCssTrait;

  public function load() {
    $module_json_folder_path = dirname( __DIR__, 3 ) . '/visual-builder/src/modules/LanguageSwitcherModule';


    add_action(
      'init',
      function() use ( $module_json_folder_path ) {
        ModuleRegistration::register_module(
          $module_json_folder_path,
          [
            'render_callback' => [ $this, 'render_callback' ],
          ]
        );
      }
    );
  }
}