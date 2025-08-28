<?php

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Direct access forbidden.' );
}

class LSDP_HELPERS {
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

	public function static_content( $exists = array() ) {
		$helpers = array(
			'defaults' => array(
				'language-switcher-for-divi-polylang' => array(
					'z_index' => 99,
				),
			),
		);

		return array_merge_recursive( $exists, $helpers );
	}

}
