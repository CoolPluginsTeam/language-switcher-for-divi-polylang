<?php
namespace LSAD\Modules\LanguageSwitcherModule\LanguageSwitcherModuleTraits;

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Direct access forbidden.' );
}

trait CustomCssTrait {
  public static function custom_css() {
    return \WP_Block_Type_Registry::get_instance()->get_registered( 'lsad/language-sitcher-module-for-divi' )->customCssFields;
  }
}