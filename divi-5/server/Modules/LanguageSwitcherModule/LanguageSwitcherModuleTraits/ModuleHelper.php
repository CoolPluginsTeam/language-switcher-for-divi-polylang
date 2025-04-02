<?php

namespace LSAD\Modules\LanguageSwitcherModule\LanguageSwitcherModuleTraits;

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}

class ModuleHelper {
    /**
     * Retrieves the attribute value from the provided attributes array.
     *
     * @param array  $attrs   The attributes array.
     * @param string $key     The key to retrieve the value for.
     * @param mixed  $default The default value to return if the key does not exist.
     *
     * @return string|null The attribute value or the default value if not found.
     */
    public static function get_attr_value($attrs, $key, $default = null)
    {
        $value = !empty($attrs[$key]['desktop']['value'][$key]) ? $attrs[$key]['desktop']['value'][$key] : $default;

        // Check if the value is an array, return it directly, otherwise, sanitize as a string
        return is_array($value) ? array_map('esc_html', $value) : esc_html($value);
    }

    static function lsad_localize_polyglang_data_divi_5( $data ) {
    
        global $polylang;
        $lsad_polylang = $polylang;
        if ( isset( $lsad_polylang ) ) {
            try {
                require_once LSPAD_DIR . 'helpers/class-lsad-helpers.php';
      
                if ( function_exists( 'pll_the_languages' ) && function_exists( 'pll_current_language' ) ) {
                    $languages = pll_the_languages( array( 'raw' => 1 ) );
                    
                    // Ensure $languages is an array
                    if ( !is_array( $languages ) || empty( $languages ) ) {
                        return $data; // Exit early if languages are not available
                    }
                    $lang_curr = strtolower( pll_current_language() ? pll_current_language() : pll_default_language() );
                    // Correct array_map function
                    $languages = array_map(
                        function( $language ) {
                            return array(
                                'flagCode'       => esc_html( \LSAD_HELPERS::get_flag_code( $language['flag'] ) ),
                                'slug'           => esc_html( $language['slug'] ),
                                'name'           => esc_html( $language['name'] ),
                                'no_translation' => esc_html( $language['no_translation'] ),
                                'url'            => esc_url( $language['url'] ),
                            );
                        },
                        $languages
                    );
                    $custom_data = array(
                        'lsadLanguangeData' => $languages,
                        'lsadCurrentLang'   => esc_html( $lang_curr ),
                        'lsadPluginUrl'     => esc_url( LSPAD_URL ),
                    );
                    $data['lsadGlobalObj'] = $custom_data;
                }
            } catch ( Exception $e ) {
                // Handle exception if needed
            }
        }
        return $data;
      }
}


