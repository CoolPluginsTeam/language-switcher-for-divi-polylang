<?php
namespace LSAD\Modules\LanguageSwitcherModule\LanguageSwitcherModuleTraits;

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}

use ET\Builder\FrontEnd\Module\Style;
use ET\Builder\Packages\Module\Options\Text\TextStyle;
use ET\Builder\Packages\Module\Options\Css\CssStyle;

trait ModuleStylesTrait {

  use CustomCssTrait;

  public static function module_styles( $args ) {
    $attrs    = $args['attrs'] ?? [];
    $elements = $args['elements'];
    $settings = $args['settings'] ?? [];

    Style::add(
      [
        'id'            => $args['id'],
        'name'          => $args['name'],
        'orderIndex'    => $args['orderIndex'],
        'storeInstance' => $args['storeInstance'],
        'styles'        => [
          // Element: Module.
          $elements->style(
            [
              'attrName'   => 'module',
              'styleProps' => [
                'disabledOn' => [
                  'disabledModuleVisibility' => $settings['disabledModuleVisibility'] ?? null,
                ],
              ],
            ]
          ),
          CssStyle::style(
            [
              'selector'  => $args['orderClass'],
              'attr'      => $attrs['css'] ?? [],
              'cssFields' => self::custom_css(),
            ]
          ),
          $elements->style(
            [
                'attrName'   => 'text_style',
            ]
        ),
        ],
      ]
    );
  }
}