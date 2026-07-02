<?php

namespace LSDP\Modules\LanguageSwitcherModule\LanguageSwitcherModuleTraits;

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}

class ModuleHelper {
    /**
     * Retrieves the attribute value from the provided attributes array.
     *
     * Returns the raw value; escape at the point of output (esc_attr, esc_html, esc_url, etc.).
     *
     * @param array  $attrs   The attributes array.
     * @param string $key     The key to retrieve the value for.
     * @param mixed  $default The default value to return if the key does not exist.
     *
     * @return mixed The attribute value or the default value if not found.
     */
    public static function get_attr_value($attrs, $key, $default = null)
    {
        if ( ! empty( $attrs[ $key ]['desktop']['value'][ $key ] ) ) {
            return $attrs[ $key ]['desktop']['value'][ $key ];
        }

        return $default;
    }

    static function lsdp_localize_polyglang_data_divi_5() {
        $data = [];
        global $polylang;
        $lsdp_polylang = $polylang;
        if ( isset( $lsdp_polylang ) ) {
            try {
                require_once LSDP_DIR . 'helpers/class-lsdp-helpers.php';
      
                if ( function_exists( 'pll_the_languages' ) && function_exists( 'pll_current_language' ) ) {
                    $languages = \LSDP_HELPERS::get_languages();
                    
                    // Ensure $languages is an array
                    if ( !is_array( $languages ) || empty( $languages ) ) {
                        return; // Exit early if languages are not available
                    }
                    $lang_curr = \LSDP_HELPERS::get_current_language();
                    if ( empty($lang_curr) ) {
                        $lang_curr = strtolower( pll_default_language() );
                    }
                    $languages = \LSDP_HELPERS::format_languages( $languages );
                    $custom_data = array(
                        'lsdpLanguageData' => $languages,
                        'lsdpCurrentLang'   => esc_html( $lang_curr ),
                        'lsdpPluginUrl'     => esc_url( LSDP_URL ),
                    );
                    $data['lsdpGlobalObj'] = $custom_data;
                }
            } catch ( Exception $e ) {
                // Handle exception if needed
            }
        }
        return $data;
      }
}


