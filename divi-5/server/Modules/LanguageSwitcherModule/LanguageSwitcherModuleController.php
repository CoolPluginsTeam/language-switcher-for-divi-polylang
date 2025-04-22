<?php
/**
 * Language Switcher Module Controller.
 *
 * @package CPFD\Modules\LanguageSwitcherModule;
 */

namespace CPFD\Modules\LanguageSwitcherModule;

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Direct access forbidden.' );
}

use CPFD\Modules\Modules;
use ET\Builder\Framework\Controllers\RESTController;
use CPFD\Modules\LanguageSwitcherModule\LanguageSwitcherModule;
use CPFD\Modules\LanguageSwitcherModule\LanguageSwitcherModuleTraits\ModuleHelper;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Class LanguageSwitcherModuleController
 *
 * @package CPFD\Modules\LanguageSwitcherModule
 */
class LanguageSwitcherModuleController extends RESTController {

  /**
   * Return data for the Dynamic Module.
   *
   * @param WP_REST_Request $request REST request object.
   *
   * @return WP_REST_Response|WP_Error
   */
  public static function index( WP_REST_Request $request ): WP_REST_Response {
    $args = [
        'switcher_layouts' => $request->get_param('switcher_layouts'),
        'show_language_flag' => $request->get_param('show_language_flag'),
        'show_language_name' => $request->get_param('show_language_name'),
        'show_language_code' => $request->get_param('show_language_code'),
        'hide_current_language' => $request->get_param('hide_current_language'),
        'hide_untranslated_language' => $request->get_param('hide_untranslated_language'),
    ];
    $response = array(
        'language_switcher_data' => ModuleHelper::cpfd_localize_polyglang_data_divi_5($args),
    );
    return rest_ensure_response($response);
  }

  /**
   * Index action arguments.
   *
   * Endpoint arguments as used in `register_rest_route()`.
   *
   * @return array
   */
  public static function index_args(): array {
    return [
      'title' => [
        'type'              => 'string',
        'default'           => '',
        'sanitize_callback' => function( $value, $request, $param ) {
          return esc_html( $value );
        },
      ],
    ];
  }

  /**
   * Index action permission.
   *
   * Endpoint permission callback as used in `register_rest_route()`.
   *
   * @return bool
   */
  public static function index_permission(): bool {
    return current_user_can('edit_posts');
  }
}