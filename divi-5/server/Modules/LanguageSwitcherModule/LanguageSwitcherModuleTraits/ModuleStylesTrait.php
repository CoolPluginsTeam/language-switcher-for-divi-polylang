<?php
namespace LSDP\Modules\LanguageSwitcherModule\LanguageSwitcherModuleTraits;

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
              'selector'            => $order_class . ' .lsdp-wrapper.dropdown ul.lsdp-language-list',
              'attr'                => $attrs['switcher_layouts'],
              'declarationFunction' => function ( $declaration_function_args ) {
                return "--lsdp-dropdown-index: 999;";
              },
            ]
          ),
          CommonStyle::style(
            [
              'selector'            => $order_class . ' .lsdp-wrapper .lsdp-lang-image',   
              'attr'                => $attrs['flag_style']['decoration']['aspect_ratio'] ?? [],
              'declarationFunction' => function ( $declaration_function_args ) {
                $attr_value = $declaration_function_args['attrValue']['aspect_ratio'] ?? [];
                if($attr_value === '1/1'){
                  return ("--lsdp-flag-ratio: {$attr_value}; --lsdp-flag-height: var(--lsdp-flag-width);");
                }else{
                  return ("--lsdp-flag-ratio: {$attr_value}; --lsdp-flag-height: calc(var(--lsdp-flag-width) * 0.75);");
                }
              },
            ]
          ),
          (($attrs['flag_style']['decoration']['aspect_ratio']['desktop']['value']['aspect_ratio'] ?? $attrs['flag_style']['innerContent']['desktop']['value']['aspect_ratio'] ?? null) === '1/1') ? (
            CommonStyle::style(
              [ 
                'selector'            => $order_class . ' .lsdp-wrapper .lsdp-lang-image',   
                'attr'                => $attrs['flag_style']['decoration']['flag_width'] ?? [],
                'declarationFunction' => function ( $declaration_function_args ) {
                  $attr_value = $declaration_function_args['attrValue']['flag_width'] ?? [];
                  if ( ! preg_match( '/^\d+(\.\d+)?(px|em|rem|%|vw|vh)?$/', $attr_value ) ) {
                    return '';
                  }
                  return ("--lsdp-flag-width: {$attr_value}; --lsdp-flag-height: {$attr_value};");
                },
              ]
            ) ): (
             
              CommonStyle::style(
                [
                  'selector'            => $order_class . ' .lsdp-wrapper .lsdp-lang-image',   
                  'attr'                => $attrs['flag_style']['decoration']['flag_width'] ?? [],
                  'declarationFunction' => function ( $declaration_function_args ) {
                    $attr_value = $declaration_function_args['attrValue']['flag_width'] ?? [];
                    if ( ! preg_match( '/^\d+(\.\d+)?(px|em|rem|%|vw|vh)?$/', $attr_value ) ) {
                      return '';
                    }
                    return ("--lsdp-flag-width: {$attr_value}; --lsdp-flag-height: calc(var(--lsdp-flag-width) * 0.75);");
                  },
                ]
              )
            ),
          CommonStyle::style(
            [
              'selector'            => $order_class . ' .lsdp-wrapper .lsdp-lang-image', 
              'attr'                => $attrs['flag_style']['decoration']['flag_border_radius'] ?? [],
              'declarationFunction' => function ( $declaration_function_args ) {
                $attr_value = $declaration_function_args['attrValue']['flag_border_radius'] ?? [];
                if ( ! preg_match( '/^\d+(\.\d+)?(px|em|rem|%|vw|vh)?$/', $attr_value ) ) {
                  return '';
                }
                return "--lsdp-flag-radius: {$attr_value};";
              },
            ]
          ),
          CommonStyle::style(
            [
              'selector'            => $order_class . ' .lsdp-wrapper ul li.lsdp-lang-item a, ' . $order_class . ' .lsdp-wrapper.dropdown',   
              'attr'                => $attrs['background_style']['decoration']['background_color'] ?? [],
              'declarationFunction' => function ( $declaration_function_args ) {
                $attr_value = $declaration_function_args['attrValue']['background_color'] ?? [];
                $attr_value = sanitize_hex_color( $attr_value );
                return "background-color: {$attr_value};";
              },
            ]
          ),
          
        ],
      ]
    );
  }
}