<?php

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Direct access forbidden.' );
}

class LSDP_HELPERS {
	private static $languages_cache        = null;
	private static $current_language_cache = null;

	public static function get_languages() {
		if ( self::$languages_cache === null ) {
			self::$languages_cache = function_exists( 'pll_the_languages' ) ? pll_the_languages( array( 'raw' => 1 ) ) : array();
		}
		return self::$languages_cache;
	}

	public static function get_current_language() {
		if ( self::$current_language_cache === null ) {
			self::$current_language_cache = function_exists( 'pll_current_language' ) ? strtolower( pll_current_language() ) : '';
		}
		return self::$current_language_cache;
	}

	public static function format_languages( $languages ) {
		return array_map(
			function( $language ) {
				return array(
					'flagCode'       => esc_html( self::get_flag_code( $language['flag'] ) ),
					'slug'           => esc_html( $language['slug'] ),
					'name'           => esc_html( $language['name'] ),
					'no_translation' => esc_html( $language['no_translation'] ),
					'url'            => esc_url( $language['url'] ),
				);
			},
			$languages
		);
	}
	public static function get_flag_code( $flag_url ) {
		$flag_code = preg_match( '/polylang\/flags\/([a-z]+)\.(png|svg|jpg|jpeg)$/i', $flag_url, $matches ) ? $matches[1] : false;
		return $flag_code;
	}

	public static function get_country_flag( $flag_url, $lang ) {
		$country_code = self::get_flag_code( $flag_url );
		$flag         = array();
		if ( $country_code && class_exists( 'PLL_Language' ) && method_exists( 'PLL_Language', 'get_flag_html' ) ) {

			$flag['path'] = LSDP_DIR . 'assets/flags/' . esc_html( $country_code ) . '.svg';
			$flag['url']  = esc_url( LSDP_URL . 'assets/flags/' . esc_html( $country_code ) . '.svg' );

			if ( ! defined( 'PLL_ENCODED_FLAGS' ) || PLL_ENCODED_FLAGS ) {
				$svg_icon = file_get_contents( $flag['path'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Ignore WordPress alternative function for file_get_contents

				$svg         = preg_replace_callback(
					'/["#<>]/',
					function( $match ) {
						switch ( $match[0] ) {
							case '"':
								return "'";
							case '#':
								return '%23';
							case '<':
								return '%3C';
							case '>':
								return '%3E';
						}
					},
					$svg_icon
				);
				$flag['src'] = 'data:image/svg+xml;utf8,' . $svg;
			} else {
				$flag['src'] = $flag['url'];
			}

			$flag_html = \PLL_Language::get_flag_html( $flag, '', $lang );
			return $flag_html;
		}

		$flag['src'] = $flag_url;
		$flag_html   = \PLL_Language::get_flag_html( $flag, '', $lang );
		return $flag_html;
	}

	public static function build_language_item( $lang, $props ) {
		$html = '';

		$show_flag = isset( $props['show_language_flag'] ) ? $props['show_language_flag'] : ( isset( $props['lsdp_flag_visibility'] ) ? $props['lsdp_flag_visibility'] : 'on' );
		$show_name = isset( $props['show_language_name'] ) ? $props['show_language_name'] : ( isset( $props['lsdp_language_name_visibility'] ) ? $props['lsdp_language_name_visibility'] : 'on' );
		$show_code = isset( $props['show_language_code'] ) ? $props['show_language_code'] : ( isset( $props['lsdp_language_code_visibility'] ) ? $props['lsdp_language_code_visibility'] : 'off' );

		if ( 'on' === $show_flag ) {
			$flag_icon = self::get_country_flag( $lang['flag'], $lang['name'] );
			$html     .= sprintf( '<div class="lsdp-lang-image">%s</div>', $flag_icon );
		}

		if ( 'on' === $show_name ) {
			$html .= sprintf( '<div class="lsdp-lang-name">%s</div>', esc_html( $lang['name'] ) );
		}

		if ( 'on' === $show_code ) {
			$html .= sprintf( '<div class="lsdp-lang-code">%s</div>', esc_html( $lang['slug'] ) );
		}

		return $html;
	}

}
