<?php
namespace LSAD\Modules\LanguageSwitcherModule\LanguageSwitcherModuleTraits;

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}

use ET\Builder\FrontEnd\Module\Style;
use ET\Builder\Packages\Module\Options\Text\TextStyle;
use ET\Builder\Packages\Module\Options\Css\CssStyle;
use ET\Builder\Packages\Module\Layout\Components\StyleCommon\CommonStyle;

trait ModuleStylesTrait {

  use CustomCssTrait;

  public static function module_styles( $args ) {
    $attrs    = $args['attrs'] ?? [];
    $order_class  = $args['orderClass'];
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

          $elements->style(
            [
                'attrName'   => 'text_style',
            ]
          ),
          $elements->style(
            [
                'attrName'   => 'background_style',
            ]
          ),
          $elements->style(
            [
                'attrName'   => 'container_size',
            ]
          ),
          $elements->style(
            [
                'attrName'   => 'flag_style',
            ]
          ),
          $elements->style(
            [
                'attrName'   => 'color_filters',
            ]
          ),
          CommonStyle::style(
            [
              'selector'            => $order_class . ' .lsad-wrapper .lsad-lang-image',   
              'attr'                => $attrs['flag_style']['decoration']['aspect_ratio'],
              'declarationFunction' => function ( $declaration_function_args ) {
                $attr_value = $declaration_function_args['attrValue']['aspect_ratio'];
                if($attr_value === '1/1'){
                  return ("--lsad-flag-ratio: {$attr_value}; --lsad-flag-height: var(--lsad-flag-width);");
                }else{
                  return ("--lsad-flag-ratio: {$attr_value}; --lsad-flag-height: calc(var(--lsad-flag-width) * 0.75);");
                }
              },
            ]
          ),
          (($attrs['flag_style']['decoration']['aspect_ratio']['desktop']['value'] ?? $attrs['flag_style']['decoration']['aspect_ratio']['innerContent']['desktop']['value']) === '1/1') ? (
            CommonStyle::style(
              [
                'selector'            => $order_class . ' .lsad-wrapper .lsad-lang-image',   
                'attr'                => $attrs['flag_style']['decoration']['flag_width'],
                'declarationFunction' => function ( $declaration_function_args ) {
                  $attr_value = $declaration_function_args['attrValue']['flag_width'];
                  return ("--lsad-flag-width: {$attr_value}; --lsad-flag-height: {$attr_value};");
                },
              ]
            ) ): (
              CommonStyle::style(
                [
                  'selector'            => $order_class . ' .lsad-wrapper .lsad-lang-image',   
                  'attr'                => $attrs['flag_style']['decoration']['flag_width'],
                  'declarationFunction' => function ( $declaration_function_args ) {
                    $attr_value = $declaration_function_args['attrValue']['flag_width'];
                    return ("--lsad-flag-width: {$attr_value}; --lsad-flag-height: calc(var(--lsad-flag-width) * 0.75);");
                  },
                ]
              )
            ),
          CommonStyle::style(
            [
              'selector'            => $order_class . ' .lsad-wrapper .lsad-lang-image',   
              'attr'                => $attrs['flag_style']['decoration']['flag_border_radius'],
              'declarationFunction' => function ( $declaration_function_args ) {
                $attr_value = $declaration_function_args['attrValue']['flag_border_radius'];
                return "--lsad-flag-radius: {$attr_value};";
              },
            ]
          ),
          CommonStyle::style(
            [
              'selector'            => $order_class . ' .lsad-wrapper ul, ' . $order_class . ' .lsad-wrapper.dropdown',   
              'attr'                => $attrs['background_style']['decoration']['color'],
              'declarationFunction' => function ( $declaration_function_args ) {
                $attr_value = $declaration_function_args['attrValue']['background_style']['decoration']['color'];
                return "--lsad-normal-bg-color: {$attr_value};";
              },
            ]
          ),
          
        ],
      ]
    );
  }
}