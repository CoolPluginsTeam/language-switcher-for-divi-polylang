<?php

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Direct access forbidden.' );
}
class LSDP_STYLE_HELPERS {
	private $render_slug = '';
	private $props       = '';
	private $order       = 0;

	public function __construct( $props, $render_slug, $order ) {
		$this->render_slug = $render_slug;
		$this->props       = $props;
		$this->order       = $order;
		$this->generate_divi_styles();
	} 

	private function generate_divi_styles() {
		$selector = '%%order_class%% .lsdp-wrapper';
		$slug     = $this->render_slug;
		$attr     = $this->props;

		ET_Builder_Element::set_style(
			$slug,
			array(
				'selector'    => $selector . '.dropdown',
				'declaration' => sprintf( '--lsdp-dropdown-index: %1$s;', ( 999 + $this->order ) ),
			)
		);

		// 1. Spacing properties
		$spacing_props = array(
			'lsdp_bg_normal_padding' => 'lsdp-lang-padding',
			'lsdp_bg_normal_margin'  => 'lsdp-lang-margin',
			'custom_margin__hover'   => 'lsdp-hover-bg-mrgn',
			'custom_padding__hover'  => 'lsdp-hover-bg-pading',
		);
		foreach ( $spacing_props as $key => $prefix ) {
			if ( isset( $attr[ $key ] ) ) {
				$this->set_spacing_styles( $slug, $selector, $prefix, esc_attr( $attr[ $key ] ) );
			}
		}

		// 2. Standard CSS properties (color, length)
		$css_props = array(
			'lsdp_bg_normal_color'                     => array( '--lsdp-normal-bg-color', 'sanitize_css_color' ),
			'lsdp_bg_normal_color__hover'              => array( '--lsdp-hover-bg-color', 'sanitize_css_color' ),
			'lsdp_flag_width'                          => array( '--lsdp-flag-width', 'sanitize_css_length' ),
			'lsdp_flag_radius'                         => array( '--lsdp-flag-radius', 'sanitize_css_length' ),
			'lsdp_text_settings_text_color'            => array( '--lsdp-normal-text-color', 'sanitize_css_color' ),
			'lsdp_text_settings_text_color__hover'     => array( '--lsdp-hover-text-color', 'sanitize_css_color' ),
			'lsdp_text_settings_letter_spacing'        => array( '--lsdp-normal-text-letter-spacing', 'sanitize_css_length' ),
			'lsdp_text_settings_letter_spacing__hover' => array( '--lsdp-hover-text-letter-spacing', 'sanitize_css_length' ),
			'lsdp_text_settings_font_size'             => array( '--lsdp-normal-text-size', 'sanitize_css_length' ),
			'lsdp_text_settings_font_size__hover'      => array( '--lsdp-hover-text-size', 'sanitize_css_length' ),
			'lsdp_text_settings_line_height'           => array( '--lsdp-normal-text-line-height', 'sanitize_css_length' ),
			'lsdp_text_settings_line_height__hover'    => array( '--lsdp-hover-text-line-height', 'sanitize_css_length' ),
		);

		foreach ( $css_props as $key => $config ) {
			if ( isset( $attr[ $key ] ) && '' !== $attr[ $key ] ) {
				$value = esc_attr( $attr[ $key ] );
				$sanitizer = $config[1];
				$sanitized = $this->$sanitizer( $value );
				if ( false !== $sanitized ) {
					ET_Builder_Element::set_style(
						$slug,
						array(
							'selector'    => $selector,
							'declaration' => sprintf( '%1$s: %2$s;', $config[0], $sanitized ),
						)
					);
				}
			}
		}

		// 3. Special cases: flag ratio
		if ( isset( $attr['lsdp_flag_ratio'] ) && '1/1' === esc_attr( $attr['lsdp_flag_ratio'] ) ) {
			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => '--lsdp-flag-height: var(--lsdp-flag-width);',
				)
			);
		}

		// 4. Special cases: font settings
		if ( isset( $attr['lsdp_text_settings_font'] ) && '' !== $attr['lsdp_text_settings_font'] ) {
			$normal_text_font = esc_attr( $attr['lsdp_text_settings_font'] );
			$this->load_google_fonts( $normal_text_font );
			$Font_properties = $this->get_font_properties( $normal_text_font );
			$font_family_css = $this->format_css_font_family( $Font_properties['fontFamily'] );
			
			if ( false !== $font_family_css ) {
				ET_Builder_Element::set_style(
					$slug,
					array(
						'selector'    => $selector,
						'declaration' => sprintf( '--lsdp-normal-text-font: %1$s;', $font_family_css ),
					)
				);
			}
			$this->set_css_custom_property( $slug, $selector, '--lsdp-normal-text-weight', $this->sanitize_css_font_weight( $Font_properties['fontWeight'] ) );
			$this->set_css_custom_property( $slug, $selector, '--lsdp-normal-text-transform', $this->sanitize_css_text_transform( $Font_properties['textTransform'] ) );
			$this->set_css_custom_property( $slug, $selector, '--lsdp-normal-text-decoration', $this->sanitize_css_text_decoration( $Font_properties['textDecoration'] ) );
			$this->set_css_custom_property( $slug, $selector, '--lsdp-normal-text-style', $this->sanitize_css_font_style( $Font_properties['fontStyle'] ) );
			$this->set_css_custom_property( $slug, $selector, '--lsdp-normal-text-decoration-color', $this->sanitize_css_color( $Font_properties['textDecorationLineColor'] ) );
			$this->set_css_custom_property( $slug, $selector, '--lsdp-normal-text-decoration-style', $this->sanitize_css_text_decoration_style( $Font_properties['textDecorationStyle'] ) );
		}
	}

	private function load_google_fonts( $font_family ) {
		$font_parts       = explode( '|', $font_family );
		$font_family_name = isset( $font_parts[0] ) ? $font_parts[0] : '';
		$font_family_name = $this->sanitize_font_family_name( $font_family_name );

		if ( false === $font_family_name ) {
			return;
		}

		$handle_suffix = sanitize_key( str_replace( ' ', '-', $font_family_name ) );
		if ( '' === $handle_suffix ) {
			return;
		}

		$url = sprintf(
			'https://fonts.googleapis.com/css2?family=%s&display=swap',
			rawurlencode( $font_family_name )
		);

		wp_enqueue_style( 'lsdp-gfonts-' . $handle_suffix, esc_url( $url ), array(), LSDP );
	}

	/**
	 * Allow-list validation for font family names from builder props.
	 *
	 * @param string $font_family_name Raw font family name.
	 * @return string|false Sanitized name, or false when invalid.
	 */
	private function sanitize_font_family_name( $font_family_name ) {
		$font_family_name = trim( (string) $font_family_name );

		if ( '' === $font_family_name || strlen( $font_family_name ) > 100 ) {
			return false;
		}

		if ( ! preg_match( '/^[A-Za-z0-9][A-Za-z0-9 _\-]*$/', $font_family_name ) ) {
			return false;
		}

		return $font_family_name;
	}

	/**
	 * Wrap a validated font family name for safe CSS custom property output.
	 *
	 * @param string $font_family_name Raw font family name.
	 * @return string|false Quoted CSS font-family value, or false when invalid.
	 */
	private function format_css_font_family( $font_family_name ) {
		$font_family_name = $this->sanitize_font_family_name( $font_family_name );

		if ( false === $font_family_name ) {
			return false;
		}

		$escaped = addcslashes( $font_family_name, "\\\"" );

		return '"' . $escaped . '"';
	}

	private function get_font_properties( $fontString ) {
		$fontParts  = explode( '|', $fontString );
		$fontFamily = $fontParts[0];
		$fontWeight = $fontParts[1];
		$fontStyle  = ! empty( $fontParts[2] ) ? 'italic' : 'normal';
		// Determine text transform
		if ( ! empty( $fontParts[3] ) ) {
			$textTransform = 'uppercase';
		} elseif ( ! empty( $fontParts[5] ) ) {
			$textTransform = 'capitalize';
		} else {
			$textTransform = 'none';
		}

		// Determine text decoration
		if ( ! empty( $fontParts[4] ) && ! empty( $fontParts[6] ) ) {
			$textDecoration = 'line-through';
		} elseif ( ! empty( $fontParts[4] ) ) {
			$textDecoration = 'underline';
		} elseif ( ! empty( $fontParts[6] ) ) {
			$textDecoration = 'line-through';
		} else {
			$textDecoration = 'none';
		}

		$textDecorationLineColor = ( ! empty( $fontParts[7] ) ) ? $fontParts[7] : '';
		$textDecorationStyle     = ( ! empty( $fontParts[8] ) ) ? $fontParts[8] : '';

		return array(
			'fontFamily'              => $fontFamily,
			'fontWeight'              => $fontWeight,
			'fontStyle'               => $fontStyle,
			'textTransform'           => $textTransform,
			'textDecoration'          => $textDecoration,
			'textDecorationLineColor' => $textDecorationLineColor,
			'textDecorationStyle'     => $textDecorationStyle,
		);
	}

	/**
	 * Output a validated CSS custom property, skipping invalid values.
	 *
	 * @param string       $slug           Module slug.
	 * @param string       $selector       CSS selector.
	 * @param string       $property_name  Custom property name (e.g. --lsdp-normal-text-weight).
	 * @param string|false $value          Sanitized value, or false when invalid.
	 */
	private function set_css_custom_property( $slug, $selector, $property_name, $value ) {
		if ( false === $value || '' === $value ) {
			return;
		}

		ET_Builder_Element::set_style(
			$slug,
			array(
				'selector'    => $selector,
				'declaration' => sprintf( '%1$s: %2$s;', $property_name, $value ),
			)
		);
	}

	/**
	 * Validate font-weight for safe use in CSS custom properties.
	 *
	 * @param string $weight Raw font weight from Divi font string.
	 * @return string|false Sanitized weight, or false when invalid.
	 */
	private function sanitize_css_font_weight( $weight ) {
		$weight = trim( (string) $weight );

		if ( '' === $weight ) {
			return false;
		}

		$keywords = array( 'normal', 'bold', 'lighter', 'bolder' );
		if ( in_array( $weight, $keywords, true ) ) {
			return $weight;
		}

		if ( preg_match( '/^[1-9]00$/', $weight ) ) {
			return $weight;
		}

		return false;
	}

	/**
	 * Validate text-transform for safe use in CSS custom properties.
	 *
	 * @param string $transform Raw text-transform value.
	 * @return string|false Sanitized value, or false when invalid.
	 */
	private function sanitize_css_text_transform( $transform ) {
		$allowed = array( 'none', 'uppercase', 'lowercase', 'capitalize' );

		return $this->sanitize_css_keyword( $transform, $allowed );
	}

	/**
	 * Validate text-decoration for safe use in CSS custom properties.
	 *
	 * @param string $decoration Raw text-decoration value.
	 * @return string|false Sanitized value, or false when invalid.
	 */
	private function sanitize_css_text_decoration( $decoration ) {
		$allowed = array( 'none', 'underline', 'line-through', 'overline' );

		return $this->sanitize_css_keyword( $decoration, $allowed );
	}

	/**
	 * Validate font-style for safe use in CSS custom properties.
	 *
	 * @param string $style Raw font-style value.
	 * @return string|false Sanitized value, or false when invalid.
	 */
	private function sanitize_css_font_style( $style ) {
		$allowed = array( 'normal', 'italic', 'oblique' );

		return $this->sanitize_css_keyword( $style, $allowed );
	}

	/**
	 * Validate text-decoration-style for safe use in CSS custom properties.
	 *
	 * @param string $style Raw text-decoration-style value.
	 * @return string|false Sanitized value, or false when invalid.
	 */
	private function sanitize_css_text_decoration_style( $style ) {
		$allowed = array( 'solid', 'double', 'dotted', 'dashed', 'wavy' );

		return $this->sanitize_css_keyword( $style, $allowed );
	}

	/**
	 * Allow-list validation for discrete CSS keyword values.
	 *
	 * @param string $value   Raw value.
	 * @param array  $allowed Permitted keyword values.
	 * @return string|false Sanitized keyword, or false when invalid.
	 */
	private function sanitize_css_keyword( $value, $allowed ) {
		$value = strtolower( trim( (string) $value ) );

		if ( '' === $value || ! in_array( $value, $allowed, true ) ) {
			return false;
		}

		return $value;
	}

	/**
	 * Validate a CSS length for safe use in custom properties.
	 *
	 * @param string $length Raw length from builder props.
	 * @return string|false Sanitized length, or false when invalid.
	 */
	private function sanitize_css_length( $length ) {
		$length = trim( (string) $length );

		if ( '' === $length ) {
			return false;
		}

		if ( ! preg_match( '/^-?\d+(\.\d+)?(px|em|rem|%|vw|vh)?$/', $length ) ) {
			return false;
		}

		return $length;
	}

	/**
	 * Validate a color for safe use in CSS custom properties.
	 *
	 * @param string $color Raw color from builder props.
	 * @return string|false Sanitized color, or false when invalid.
	 */
	private function sanitize_css_color( $color ) {
		$color = trim( (string) $color );

		if ( '' === $color ) {
			return false;
		}

		$hex = sanitize_hex_color( $color );
		if ( $hex ) {
			return $hex;
		}

		if ( preg_match( '/^rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(0|1|0?\.\d+)\s*)?\)$/i', $color, $matches ) ) {
			$red   = (int) $matches[1];
			$green = (int) $matches[2];
			$blue  = (int) $matches[3];

			if ( $red > 255 || $green > 255 || $blue > 255 ) {
				return false;
			}

			if ( isset( $matches[4] ) && '' !== $matches[4] && (float) $matches[4] > 1 ) {
				return false;
			}

			if ( isset( $matches[4] ) && '' !== $matches[4] ) {
				return sprintf( 'rgba(%d,%d,%d,%s)', $red, $green, $blue, $matches[4] );
			}

			return sprintf( 'rgb(%d,%d,%d)', $red, $green, $blue );
		}

		return false;
	}

	/**
	 * Output validated spacing values as CSS custom properties.
	 *
	 * @param string $slug            Module slug.
	 * @param string $selector        CSS selector.
	 * @param string $property_prefix Custom property prefix.
	 * @param string $unit_string     Pipe-delimited Divi spacing string.
	 */
	private function set_spacing_styles( $slug, $selector, $property_prefix, $unit_string ) {
		if ( '' === $unit_string ) {
			return;
		}

		$allowed_sides = array( 'top', 'right', 'bottom', 'left' );
		$spacing       = $this->get_unit_value( $unit_string );

		foreach ( $spacing as $side => $value ) {
			if ( ! in_array( $side, $allowed_sides, true ) || '' === $value ) {
				continue;
			}

			$length = $this->sanitize_css_length( $value );
			if ( false === $length ) {
				continue;
			}

			ET_Builder_Element::set_style(
				$slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf( '--%1$s-%2$s: %3$s;', $property_prefix, $side, $length ),
				)
			);
		}
	}

	private function get_unit_value( $unitString ) {
		$units = explode( '|', $unitString );

		return array(
			'top'    => $units[0],
			'bottom' => $units[2],
			'left'   => $units[3],
			'right'  => $units[1],
		);
	}
}
